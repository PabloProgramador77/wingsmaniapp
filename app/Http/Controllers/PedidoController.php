<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Domicilio;
use App\Models\Platillo;
use App\Models\Envio;
use App\Models\Paquete;
use Illuminate\Http\Request;
use App\Http\Requests\Pedido\Create;
use App\Http\Requests\Pedido\Delete;
use App\Http\Requests\Pedido\Ordenar;
use App\Http\Requests\Pedido\Entregar;
use App\Http\Requests\Pedido\Cobrar;
use App\Http\Requests\Pedido\Pagar;
use App\Http\Requests\Pedido\ReadDomicilio;
use App\Notifications\NuevoPedido;
use App\Events\OrdenarPedido;
use App\Events\ConfirmarPedidoEvent;
use App\Notifications\ConfirmarPedidoNotification;
use App\Notifications\CobrarPedidoNotificacion;
use App\Events\CobrarPedidoEvent;
use Illuminate\Support\Facades\Notification;
use \Mpdf\Mpdf as PDF;
use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Vonage\Client\Credentials\Basic;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id && !auth()->User()->hasRole('Cliente') ){

            $pedidos = Pedido::where('estatus', '!=', 'Corte')
                        ->where('estatus', '!=', 'Ordenando')
                        ->orderBy('created_at', 'desc')->get();

            $envios = Envio::all();

            return view('pedido.index', compact('pedidos', 'envios'));

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
            $pedido = Pedido::find( session()->get('idPedido') );
            $platillosPedido = Platillo::select('pedido_has_platillos.id', 'pedido_has_platillos.cantidad', 'pedido_has_platillos.preparacion', 'platillos.nombre')
                                ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                                ->where('pedido_has_platillos.idPedido', '=', session()->get('idPedido'))
                                ->get();

            $paquetesPedido = Paquete::select('pedido_has_paquetes.id', 'pedido_has_paquetes.cantidad', 'pedido_has_paquetes.preparacion', 'paquetes.nombre')
                            ->join('pedido_has_paquetes', 'paquetes.id', '=', 'pedido_has_paquetes.idPaquete')
                            ->where('pedido_has_paquetes.idPedido', '=', session()->get('idPedido'))
                            ->get();

            if( session()->get('idPedidoPaquete') ){

                session()->forget('idPedidoPaquete');

                return view('menu', compact('categorias', 'pedido', 'platillosPedido', 'paquetesPedido'));

            }else{

                return view('menu', compact('categorias', 'pedido', 'platillosPedido', 'paquetesPedido'));

            }

            

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
                'estatus' => 'Ordenando',
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
            $pedido->estatus = 'Pendiente';
            $pedido->save();

            if( $pedido->id ){

                if( $pedido->tipo == 'pickup' ){

                    $this->notification();
                    $this->comanda( $pedido );

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

                            $domicilios = $pedido->cliente->domicilios;

                            foreach( $domicilios as $domicilio ){

                                $pedido->idDomicilio = $domicilio->id;
                                $pedido->save();

                            }

                            $this->notification();
                            $this->comanda( $pedido );

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

                $pedido = Pedido::find( session()->get('idPedido') );
                $pedido->idDomicilio = $request->idDomicilio;
                $pedido->save();

                $this->notification();
                $this->comanda( $pedido );

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

                $this->cancelacion( $pedido );

                $pedido->delete();

                session()->forget('idPedido');

                $datos['exito'] = true;
                
                if( auth()->user()->hasRole('Cliente') ){

                    $datos['url'] = '/home';

                }else{

                    $datos['url'] = '/pedido/cancelado/'.$request->id; 

                }

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

            $platillosPedido = collect();

            if( $pedido->id ){

                $platillos = Platillo::select('platillos.nombre', 'platillos.precio', 'pedido_has_platillos.cantidad', 'pedido_has_platillos.preparacion')
                            ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                            ->where('pedido_has_platillos.idPedido', '=', $idPedido)
                            ->get();

                $platillosPedido = $platillosPedido->merge( $platillos );

                $paquetes = Paquete::select('paquetes.nombre', 'paquetes.precio', 'pedido_has_paquetes.cantidad', 'pedido_has_paquetes.preparacion')
                            ->join('pedido_has_paquetes', 'paquetes.id', '=', 'pedido_has_paquetes.idPaquete')
                            ->where('pedido_has_paquetes.idPedido', '=', $idPedido)
                            ->get();

                $platillosPedido = $platillosPedido->merge( $paquetes );

                return view('pedido.pedido', compact('pedido', 'platillos', 'paquetes'));

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
    public function confirmar($id){
        try {
            
            //$pedido = Pedido::find( $id );

            //event( new ConfirmarPedidoEvent( $pedido ) );
            
            //$this->confirmar_notification( $pedido );

            $pedido = Pedido::where('id', '=', $id)
                ->update([

                    'estatus' => 'Abierto'

                ]);

            return redirect('/pedidos');

        } catch (\Throwable $th) {
            
            return redirect('/');

        }

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

            if( $pedido->tipo == 'delivery' ){

                foreach( $request->envios as $envio ){

                    $pedido->idEnvio = $envio;
                    $pedido->save();

                }

                $pedido->total += $pedido->envio->monto;
                $pedido->save();

            }

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

            $platillosComanda = collect();

            $comanda->writeHTML('<h1 style="font-size: 24px; text-align: center; font-style: bold;">COMANDA DE COCINA</h1>');
            $comanda->writeHTML('<h3 style="font-size: 14px; text-align: center;">'.$pedido->created_at.'</h3>');
            $comanda->writeHTML('<p style="font-size: 14px; text-align: center; font-style: bold;">Para llevar</p>');
            $comanda->writeHTML('<p style="font-size: 14px; text-align: center; font-style: bold;"><u>'.$pedido->cliente->name.'</u></p>');
            
            $platillos = Platillo::select('platillos.nombre', 'pedido_has_platillos.cantidad', 'pedido_has_platillos.preparacion')
                        ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                        ->where('pedido_has_platillos.idPedido', '=', $pedido->id)
                        ->get();

            $platillosComanda = $platillosComanda->merge( $platillos );

            $paquetes = Paquete::select('paquetes.nombre', 'pedido_has_paquetes.preparacion', 'pedido_has_paquetes.cantidad')
                        ->join('pedido_has_paquetes', 'paquetes.id', '=', 'pedido_has_paquetes.idPaquete')
                        ->where('pedido_has_paquetes.idPedido', '=', $pedido->id)
                        ->get();

            $platillosComanda = $platillosComanda->merge( $paquetes );

            foreach( $platillosComanda as $platillo ){

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

            $platillosTicket = collect();

            $platillos = Platillo::select('platillos.nombre', 'pedido_has_platillos.cantidad', 'platillos.precio')
                        ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                        ->where('pedido_has_platillos.idPedido', '=', $pedido->id)
                        ->get();

            $platillosTicket = $platillosTicket->merge( $platillos );

            $paquetes = Paquete::select('paquetes.nombre', 'paquetes.precio', 'pedido_has_paquetes.cantidad')
                        ->join('pedido_has_paquetes', 'paquetes.id', '=', 'pedido_has_paquetes.idPaquete')
                        ->where('pedido_has_paquetes.idPedido', '=', $pedido->id)
                        ->get();

            $platillosTicket = $platillosTicket->merge( $paquetes );

            $ticket->writeHTML('<p style="font-size: 16px; font-style: bold; text-align: center; padding: 0px;">Wings Mania</p>');
            $ticket->writeHTML('<p style="font-size: 12px; font-style: normal; text-align: center; padding: 0px;">'.strtoupper($pedido->tipo).'</p>');
            $ticket->writeHTML('<p style="font-size: 12px; font-style: bold; text-align: center; padding: 0px;">'.$pedido->cliente->name.'</p>');
            $ticket->writeHTML('<p style="font-size: 8px; font-style: normal; text-align: center; padding: 0px;" >Hora de Impresión: '.date('Y-m-d H:m:s').'</p>');
            $ticket->writeHTML('<p style="font-size: 10px; font-style: bold; text-align: center; padding: 0px;">#'.$pedido->id.'</p>');

            $total = 0;

            foreach( $platillosTicket as $platillo ){

                $ticket->writeHTML('<p style="font-size: 11px; text-align: center; width: 100%;">'.$platillo->cantidad.' - '.$platillo->nombre.' $'.($platillo->precio * $platillo->cantidad).'</p>');

                $total += ( $platillo->precio * $platillo->cantidad );

            }

            if( $pedido->tipo == 'delivery' ){

                $total += $pedido->envio->monto;

                $ticket->writeHTML('<p style="width: 100%; display: block;"><p style="width: 100%; text-align: center; font-size: 11px; ">Envio a domicilio: $'.$pedido->envio->monto.'</p>');
                $ticket->writeHTML('<p style="width: 100%; display: block;"><p style="width: 100%; display: block; text-align: center; font-size: 11px;"><b>Total: $'.$total.'</b></p>');
                
            }else{

                $ticket->writeHTML('<p style="width: 100%; display: block;"><p style="width: 100%; display: block; text-align: center; font-size: 12px;"><b>Total: $'.$total.'</b></p>');
                
            }

            if( file_exists( public_path('tickets') ) ){

                $ticket->Output(public_path('tickets/').'ticket'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE);

                if( $pedido->tipo == 'delivery' ){

                    $this->entrega( $pedido );

                }

            }else{

                mkdir( public_path('tickets'), 0777, true );

                $ticket->Output(public_path('tickets/').'ticket'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE);

                if( $pedido->tipo == 'delivery' ){

                    $this->entrega( $pedido );
                    
                }

            }
            
        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Creación de ticket de entrega de pedido
     */
    public function entrega( $pedido ){
        try {
            
            $ticket = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 2700],
                'orientation' => 'P',
                'autoPageBreak' => false,

            ]);

            $ticket->writeHTML('<p style="font-size: 16px; font-style: bold; text-align: center; padding: 0px;">Wings Mania</p>');
            $ticket->writeHTML('<p style="font-size: 11px; font-style: bold; text-align: center; padding: 0px;">#'.$pedido->id.'</p>');
            $ticket->writeHTML('<p style="font-size: 12px; font-style: normal; text-align: center; padding: 0px;">'.strtoupper($pedido->tipo).'</p>');
            $ticket->writeHTML('<p style="font-size: 14px; font-style: bold; text-align: center; padding: 0px;">'.$pedido->cliente->name.'</p>');
            $ticket->writeHTML('<p style="font-size: 14px; font-style: bold; text-align: center; padding: 0px;">'.$pedido->domicilio->direccion.'</p>');

            if( file_exists( public_path('entregas') ) ){

                $ticket->Output( public_path('entregas/').'entrega'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }else{

                mkdir( public_path('entregas'), 0777, true );

                $ticket->Output( public_path('entregas/').'entrega'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }

        } catch (\Throwable $th) {

            echo $th->getMessage();

        }
    }

    /**
     * Comanda de pedido cancelado
     */
    public function cancelacion( $pedido ){
        try {
            
            $comanda = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 2700],
                'orientation' => 'P',
                'autoPageBreak' => false,

            ]);

            $comanda->writeHTML('<p style="font-size: 18px; font-style: bold; text-align: center; padding: 0px;"><b>PEDIDO CANCELADO</b></p>');
            $comanda->writeHTML('<p style="font-size: 14px; font-style: normal; text-align: center; padding: 0px;">'.strtoupper($pedido->tipo).'</p>');
            $comanda->writeHTML('<p style="font-size: 14px; font-style: bold; text-align: center; padding: 0px;">'.$pedido->cliente->name.'</p>');
            $comanda->writeHTML('<p style="font-size: 8px; font-style: normal; text-align: center; padding: 0px;">Hora de Impresión: '.date('Y-m-d H:m:s').'</p>');

            if( public_path('comandas/canceladas/') ){

                $comanda->Output( public_path('comandas/canceladas/').'comandaCancelada'.$pedido->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**Impresión de comanda */
    public function impresion( $id ){
        try {

            $pedido = Pedido::where('id', '=',  $id )
                    ->update([

                        'estatus' => 'Abierto'

                    ]);
            
            $headers = [

                'Content-Type' => 'application/pdf'
            
            ];

            if( file_exists( public_path( 'comandas/' ).'comanda'.$id.'.pdf' ) ){

                ob_end_clean();

                return response()->download( public_path( 'comandas/' ).'comanda'.$id.'.pdf', 'comanda'.$id.'.pdf', $headers );

            }else{

                $pedido = Pedido::find( $id );

                $this->comanda( $pedido );

                return response()->download( public_path('comandas/').'comanda'.$id.'.pdf', 'comanda'.$id.'.pdf', $headers );

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Búsqueda de domicilio de pedido
     */
    public function domicilio(ReadDomicilio $request){
        try {
            
            $pedido = Pedido::find( $request->id );

            if( $pedido->id ){

                $datos['exito'] = true;
                $datos['domicilio'] = $pedido->domicilio->direccion;
                $datos['total'] = $pedido->total;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Descarga de ticket
     * 
     */
    public function descargarTicket( $id ){
        try {
            
            $pedido = Pedido::find( $id );

            if( $pedido->id ){
                
                $headers = [

                    'Content-Type' => 'application/pdf'
                
                ];

                if( $pedido->tipo == 'delivery' ){

                    return response()->download( public_path('tickets/').'ticket'.$id.'.pdf', 'ticket'.$id.'.pdf', $headers );

                }else{

                    return response()->download( public_path('tickets/').'ticket'.$id.'.pdf', 'ticket'.$id.'.pdf', $headers );

                }

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Descarga del PDF de entrega
     */
    public function descargarEntrega( $id ){
        try {
            
            $headers = [

                'Content-Type' => 'application/pdf'
            
            ];

            return response()->download( public_path('entregas/').'entrega'.$id.'.pdf', 'entrega'.$id.'.pdf', $headers );

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Descarga de PDF cancelación
     */
    public function descargarCancelacion( $id ){
        try {
            
            $headers = [

                'Content-Type' => 'application/pdf'
            
            ];

            return response()->download( public_path('comandas/canceladas/').'comandaCancelada'.$id.'.pdf' );

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

}
