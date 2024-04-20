<?php

namespace App\Http\Controllers;

use App\Models\PedidoHasPlatillo;
use App\Models\Platillo;
use App\Models\Pedido;
use App\Models\Paquete;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoHasPlatillo\Create;
use App\Http\Requests\PedidoHasPlatillo\Update;
use App\Http\Requests\PedidoHasPlatillo\Delete;
use App\Http\Requests\PedidoHasPlatillo\Sumar;
use App\Http\Requests\PedidoHasPlatillo\Restar;

class PedidoHasPlatilloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id)
    {
        try {
            
            $pedidoHasPlatillo = PedidoHasPlatillo::create([

                'idPedido' => session()->get('idPedido'),
                'idPlatillo' => $id,
                'cantidad' => 1,

            ]);

            if( $pedidoHasPlatillo->id ){

                $pedido = Pedido::find( session()->get('idPedido') );

                $platillo = Platillo::find( $pedidoHasPlatillo->idPlatillo );

                $totalPedido = $this->total();

                if( $totalPedido > 0 ){

                    if( $platillo->salsas->count() > 0 || $platillo->preparaciones->count() > 0 ){

                        $salsas = $platillo->salsas;
                        $preparaciones = $platillo->preparaciones;
    
                        return view('preparar', compact('salsas', 'preparaciones', 'platillo', 'pedidoHasPlatillo'));
    
                    }else{
    
                        return redirect('/categoria/platillos/'.$platillo->categoria->id);
    
                    }

                }else{

                    return redirect('/categoria/platillos/'.$platillo->categoria->id);

                }

            }

        } catch (\Throwable $th) {
            
            echo "Error: ".$th->getMessage();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PedidoHasPlatillo $pedidoHasPlatillo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PedidoHasPlatillo $pedidoHasPlatillo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {

            $preparacionPlatillo = '';
            
            if( is_array( $request->salsas ) && count( $request->salsas ) > 0 ){

                foreach($request->salsas as $salsa){

                    $preparacionPlatillo .= $salsa.', ';

                }

            }

            if( is_array( $request->preparaciones ) && count( $request->preparaciones ) > 0 ){

                foreach($request->preparaciones as $preparacion){

                    $preparacionPlatillo .= $preparacion.', ';

                }

            }

            $pedidoHasPlatillo = PedidoHasPlatillo::where('id', '=', $request->id)
                ->update([

                    'preparacion' => $preparacionPlatillo

                ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $pedidoHasPlatillo = PedidoHasPlatillo::find($request->id);

            if( $pedidoHasPlatillo->id ){

                $pedidoHasPlatillo->delete();

                $pedido = Pedido::find( session()->get('idPedido') );

                $totalPedido = $this->total();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Suma de la cantidad del platillo en pedido
     */
    public function sumar(Sumar $request){
        try {

            $cantidad = PedidoHasPlatillo::select('cantidad')
                ->where('id', '=', $request->id)
                ->first();

            $cantidad->cantidad = $cantidad->cantidad + 1;

            $pedidoHasPlatillo = PedidoHasPlatillo::where('id', '=', $request->id)
                ->update([

                    'cantidad' => $cantidad->cantidad

                ]);

            $pedido = Pedido::find( session()->get('idPedido') );

            $totalPedido = $this->total();

            $datos['exito'] = true;
            $datos['cantidad'] = $cantidad->cantidad;
            $datos['total'] = $totalPedido;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Restar cantidad del platillo en pedido
     */
    public function restar(Restar $request){
        try {
            
            $cantidad = PedidoHasPlatillo::select('cantidad')
                ->where('id', '=', $request->id)
                ->first();

            $cantidad->cantidad = $cantidad->cantidad - 1;

            if( $cantidad->cantidad == 0 ){

                $pedidoHasPlatillo = PedidoHasPlatillo::where('id', '=', $request->id);
                $pedidoHasPlatillo->delete();

            }else{

                $pedidoHasPlatillo = PedidoHasPlatillo::where('id', '=', $request->id)
                    ->update([

                    'cantidad' => $cantidad->cantidad

                ]);

            }

            $pedido = Pedido::find( session()->get('idPedido') );
            $totalPedido = $this->total();

            $datos['exito'] = true;
            $datos['cantidad'] = $cantidad->cantidad;
            $datos['total'] = $totalPedido;
            
        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Cálculo del total del pedido
     * Total += ( precioPlatilo * cantidadPlatillo )
     */
    public function total(){
        try {

            $total = 0;
            
            $platillos = collect();

            $pedido = Pedido::find( session()->get('idPedido') );

            $platillosPedido = Platillo::select('platillos.precio', 'pedido_has_platillos.cantidad')
                ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                ->where('pedido_has_platillos.idPedido', '=', session()->get('idPedido'))
                ->get();

            $platillos = $platillos->merge( $platillosPedido );

            $paquetesPedido = Paquete::select('paquetes.precio', 'pedido_has_paquetes.cantidad')
                        ->join('pedido_has_paquetes', 'paquetes.id', '=', 'pedido_has_paquetes.idPaquete')
                        ->where('pedido_has_paquetes.idPedido', '=', session()->get('idPedido'))
                        ->get();

            $platillos = $platillos->merge( $paquetesPedido );

            if( count( $platillos ) > 0 ){

                foreach( $platillos as $platillo ){

                    $total += ($platillo->precio * $platillo->cantidad);

                }

                $pedido = Pedido::where('id', '=', session()->get('idPedido'))
                        ->update([

                            'total' => $total

                ]);

                return $total;

            }else{

                $pedido = Pedido::where('id', '=', session()->get('idPedido'))
                    ->update([

                        'total' => $total

                    ]);

                return $total;

            }

        } catch (\Throwable $th) {
            
            echo "Fatal Error: ".$th->getMessage();

        }
    }
}
