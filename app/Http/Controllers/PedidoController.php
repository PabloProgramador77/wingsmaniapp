<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Domicilio;
use App\Models\Platillo;
use Illuminate\Http\Request;
use App\Http\Requests\Pedido\Create;
use App\Http\Requests\Pedido\Delete;
use App\Http\Requests\Pedido\Ordenar;
use App\Http\Requests\Pedido\Entregar;
use App\Http\Requests\Pedido\Confirm;
use App\Http\Requests\Pedido\Cobrar;
use App\Http\Requests\Pedido\Pagar;
use App\Notifications\NuevoPedido;
use App\Events\OrdenarPedido;
use App\Events\ConfirmarPedidoEvent;
use App\Notifications\ConfirmarPedidoNotification;
use App\Notifications\CobrarPedidoNotificacion;
use App\Events\CobrarPedidoEvent;
use Illuminate\Support\Facades\Notification;
use \Mpdf\Mpdf as PDF;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id && !auth()->User()->hasRole('Cliente') ){

            $pedidos = Pedido::where('estatus', '!=', 'Corte')->orderBy('created_at', 'desc')->get();

            return view('pedido.index', compact('pedidos'));

        }else{

            return redirect('/');
            
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if( auth()->user()->id && auth()->user()->hasRole('Cliente') && session()->get('idPedido') ){

            $categorias = Categoria::all();

            return view('menu', compact('categorias'));

        }else{

            return redirect('/');

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {
            
            $pedido = Pedido::create([

                'total' => 0,
                'estatus' => 'Pendiente',
                'tipo' => $request->tipo,
                'idCliente' => auth()->user()->id

            ]);

            if( $pedido->id ){

                session()->put('idPedido', $pedido->id);

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            
            if( auth()->user()->id && auth()->user()->hasRole('Cliente') ){

                $pedidos = Pedido::where('idCliente', '=', auth()->user()->id)->get();

                return view('pedido.cliente', compact('pedidos'));

            }else{

                return redirect('/');

            }

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Finalizando pedido y mostrando domicilios en caso de ser necesario
     */
    public function edit(Ordenar $request)
    {
        try {
            
            $pedido = Pedido::find( $request->id );

            if( $pedido->id ){

                if( $pedido->tipo == 'pickup' ){

                    $this->notification();

                    session()->forget('idPedido');

                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Pedido Enviado a Restaurante.';
                    $datos['url'] = '/pedidos/cliente';

                }else{

                    if( count( auth()->user()->domicilios ) > 0 ){

                        if( count( auth()->user()->domicilios ) > 1 ){

                            $datos['exito'] = true;
                            $datos['mensaje'] = 'Elige el domicilio para entregar tu pedido.';
                            $datos['url'] = '/pedido/domicilios';

                        }else{

                            $this->notification();

                            session()->forget('idPedido');

                            $datos['exito'] = true;
                            $datos['mensaje'] = 'Pedido Enviado a Restaurante.';
                            $datos['url'] = '/pedidos/cliente';

                        }

                    }else{

                        $datos['exito'] = true;
                        $datos['mensaje'] = 'Registra un domicilio para entregar tu pedido.';
                        $datos['url'] = '/pedido/domicilios';

                    }                 

                }

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Entregar $request)
    {
        try {
            
            $domicilio = Domicilio::find( $request->idDomicilio );

            if( $domicilio->id ){

                $this->notification();

                session()->forget('idPedido');

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $pedido = Pedido::find( $request->id );

            if( $pedido->id ){

                $pedido->delete();

                session()->forget('idPedido');

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Consulta detallada de pedido
     */
    public function pedido($idPedido){
        try {
            
            $pedido = Pedido::find( $idPedido );

            if( $pedido->id ){

                $platillos = Platillo::select('platillos.nombre', 'platillos.precio', 'pedido_has_platillos.cantidad', 'pedido_has_platillos.preparacion')
                    ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                    ->where('pedido_has_platillos.idPedido', '=', $idPedido)
                    ->get();

                return view('pedido.pedido', compact('pedido', 'platillos'));

            }else{

                return redirect('/pedidos/cliente');
            }

        } catch (\Throwable $th) {

            return redirect('/pedidos/cliente');

        }
    }

    /**
     * Notificación de nuevo
     */
    public function notification(){
        try {
            
            $pedido = Pedido::find( session()->get('idPedido') );

            event(new OrdenarPedido( $pedido ) );

        } catch (\Throwable $th) {
            
            echo "Error: ".$th->getMessage();

        }
    }

    /**
     * Búsqueda Platills & Pedido
     */
    public function confirmar(Confirm $request){
        try {
            
            $pedido = Pedido::find( $request->id );

            event( new ConfirmarPedidoEvent( $pedido ) );
            
            $this->confirmar_notification( $pedido );
            $this->comanda( $pedido );

            $pedido = Pedido::where('id', '=', $request->id)
                ->update([

                    'estatus' => 'Abierto'

                ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Confirmar notificacion de pedido
     */
    public function confirmar_notification($pedido){
        try {
            
            $notification = \DB::table('notifications')
                ->where('notifiable_id', '=', auth()->user()->id)
                ->where('data->id', '=', $pedido->id)
                ->update(['read_at' => now()]);

        } catch (\Throwable $th) {
            
            echo "Error: ".$th->getMessage();

        }
    }

    /**
     * Cobrar Pedido
     */
    public function cobrar( Cobrar $request ){
        try {
            
            $pedido = Pedido::find( $request->id );

            event( new CobrarPedidoEvent( $pedido ) );

            $this->ticket( $pedido );

            if( $pedido->id ){

                $pedido = Pedido::where('id', '=', $request->id)
                    ->update([

                        'estatus' => 'Cobrado'

                    ]);

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Confirmar Pago de Pedido
     */
    public function pagar( Pagar $request ){
        try {
            
            $pedido = Pedido::find( $request->id );

            if( $pedido->id ){

                $pedido = Pedido::where('id', '=', $request->id)
                    ->update([

                        'estatus' => 'Pagado'

                    ]);

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Creación de comanda de pedido PDF
     */
    public function comanda( $pedido ){
        try {
            
            $comanda = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 2700],
                'orientation' => 'P',
                'autoPageBreak' => false,

            ]);

            $comanda->writeHTML('<h1 style="font-size: 24px; text-align: center; font-style: bold;">COMANDA DE COCINA</h1>');
            $comanda->writeHTML('<h3 style="font-size: 14px; text-align: center;">'.$pedido->created_at.'</h3>');
            $comanda->writeHTML('<p style="font-size: 14px; text-align: center; font-style: bold;">Para llevar</p>');
            $comanda->writeHTML('<p style="font-size: 14px; text-align: center; font-style: bold;"><u>'.$pedido->cliente->name.'</u></p>');
            
            $platillos = Platillo::select('platillos.nombre', 'pedido_has_platillos.cantidad', 'pedido_has_platillos.preparacion')
                        ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                        ->where('pedido_has_platillos.idPedido', '=', $pedido->id)
                        ->get();

            foreach( $platillos as $platillo ){

                $comanda->writeHTML('<p style="font-size: 24px; font-style: bold;">'.$platillo->cantidad.' '.$platillo->nombre.'</p>');
                $comanda->writeHTML('<p style="font-size: 22px; font-style: bold;"><u>'.$platillo->preparacion.'</u></p>');

            }

            if( file_exists( public_path('comandas') ) ){

                $comanda->Output( public_path('comandas/').'comanda'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }else{

                mkdir( public_path('comandas'), 0777, true );

                $comanda->Output( public_path('comandas/').'comanda'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }

    }

    /**
     * Creación de ticket PDF
     */
    public function ticket( $pedido ){
        try {
            
            $ticket = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 2700],
                'orientation' => 'P',
                'autoPageBreak' => false,

            ]);

            $platillos = Platillo::select('platillos.nombre', 'pedido_has_platillos.cantidad', 'platillos.precio')
                        ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                        ->where('pedido_has_platillos.idPedido', '=', $pedido->id)
                        ->get();

            $ticket->writeHTML('<p style="font-size: 18px; font-style: bold; text-align: center; padding: 0px;">Wings Mania</p>');
            $ticket->writeHTML('<p style="font-size: 14px; font-style: normal; text-align: center; padding: 0px;">'.strtoupper($pedido->tipo).'</p>');
            $ticket->writeHTML('<p style="font-size: 14px; font-style: bold; text-align: center; padding: 0px;">'.$pedido->cliente->name.'</p>');
            $ticket->writeHTML('<p style="font-size: 10px; font-style: normal; text-align: center; padding: 0px;">'.date('Y-m-d H:m:s').'</p>');
            $ticket->writeHTML('<p style="font-size: 11px; font-style: bold; text-align: center; padding: 0px;">#'.$pedido->id.'</p>');

            $ticket->writeHTML('<table style="width: 100%;">');
            $ticket->writeHTML('<tbody width="100%;">');

            $total = 0;

            foreach( $platillos as $platillo ){

                $ticket->writeHTML('<tr style="width: 100%; display: inline-block;">');
                $ticket->writeHTML('<td style="font-size: 12px; text-align: left; width: 10%;">'.$platillo->cantidad.'</td>');
                $ticket->writeHTML('<td style="font-size: 12px; text-align: left; width: 70%;">'.$platillo->nombre.'</td>');
                $ticket->writeHTML('<td style="font-size: 12px; text-align: left; width: 20%;">$'.( $platillo->precio * $platillo->cantidad ).'</td>');
                $ticket->writeHTML('</tr>');

                $total += ( $platillo->precio * $platillo->cantidad );

            }

            $ticket->writeHTML('<tr style="width: 100%; display: block;"><td style="width: 100%; display: block; text-align: center; font-size: 12px;" colspan="3">Total: $'.$total.'</td></tr>');
            $ticket->writeHTML('</tbody>');
            $ticket->writeHTML('</table>');

            if( file_exists( public_path('tickets') ) ){

                $ticket->Output(public_path('tickets/').'ticket'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE);

            }else{

                mkdir( public_path('tickets') );

                $ticket->Output(public_path('tickets/').'ticket'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE);

            }
            
        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

}
