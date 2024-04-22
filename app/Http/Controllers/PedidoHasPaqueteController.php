<?php

namespace App\Http\Controllers;

use App\Models\PedidoHasPaquete;
use App\Models\Pedido;
use App\Models\Paquete;
use App\Models\Salsa;
use App\Models\Platillo;
use App\Models\Preparacion;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoHasPaquete\Update;
use App\Http\Requests\PedidoHasPaquete\Delete;
use App\Http\Requests\PedidoHasPaquete\Restar;
use App\Http\Requests\PedidoHasPaquete\Sumar;

class PedidoHasPaqueteController extends Controller
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
            
            $pedidoHasPaquete = PedidoHasPaquete::create([

                'idPedido' => session()->get('idPedido'),
                'idPaquete' => $id,
                'cantidad' => 1

            ]);

            if( $pedidoHasPaquete->id ){

                $pedido = Pedido::find( session()->get('idPedido') );

                $paquete = Paquete::find( $id );

                $totalPedido = $this->total();

                $salsas = Salsa::select('salsas.id', 'salsas.nombre')
                        ->join( 'platillo_has_salsas', 'salsas.id', '=', 'platillo_has_salsas.idSalsa' )
                        ->join( 'paquete_has_platillos', 'platillo_has_salsas.idPlatillo', '=', 'paquete_has_platillos.idPlatillo' )
                        ->where( 'paquete_has_platillos.idPaquete', '=', $id )
                        ->get();

                $preparaciones = Preparacion::select('preparaciones.id', 'preparaciones.nombre')
                        ->join( 'platillo_has_preparaciones', 'preparaciones.id', '=', 'platillo_has_preparaciones.idPreparacion' )
                        ->join( 'paquete_has_platillos', 'platillo_has_preparaciones.idPlatillo', '=', 'paquete_has_platillos.idPlatillo' )
                        ->where( 'paquete_has_platillos.idPaquete', '=', $id )
                        ->get();

                $bebidas = Platillo::select('platillos.id', 'platillos.nombre')
                        ->join( 'paquete_has_bebidas', 'platillos.id', '=', 'paquete_has_bebidas.idBebida' )
                        ->where( 'paquete_has_bebidas.idPaquete', '=', $id )
                        ->get();

                if( count( $salsas ) > 0 || count( $preparaciones ) > 0 || count( $bebidas ) > 0 ){

                    return view('paquete', compact( 'paquete', 'pedidoHasPaquete' ));

                }else{

                    return redirect('/categoria/platillos/'.$paquete->categoria->id);

                }

            }else{

                return redirect('/categoria/platillos/'.$paquete->categoria->id);

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PedidoHasPaquete $pedidoHasPaquete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PedidoHasPaquete $pedidoHasPaquete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {

            $pedidoHasPaquete = PedidoHasPaquete::where('id', '=', $request->id )
                                ->update([

                                    'preparacion' => $request->preparaciones

            ]);

            $datos['exito'] = true;

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
            
            $pedidoHasPaquete = PedidoHasPaquete::find( $request->id );

            if( $pedidoHasPaquete->id ){

                $pedidoHasPaquete->delete();

                $totalPedido = $this->total();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Calculo y suma del total del pedido
     */
    public function total(){
        try {

            $total = 0;
            $platillos = collect();

            $pedido = Pedido::find( session()->get('idPedido') );

            $paquetesPedido = Paquete::select('paquetes.precio', 'pedido_has_paquetes.cantidad')
                            ->join('pedido_has_paquetes', 'paquetes.id', '=', 'pedido_has_paquetes.idPaquete')
                            ->where('pedido_has_paquetes.idPedido', '=', session()->get('idPedido'))
                            ->get();

            $platillos = $platillos->merge( $paquetesPedido );

            $platillosPedido = Platillo::select('platillos.precio', 'pedido_has_platillos.cantidad')
                            ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                            ->where('pedido_has_platillos.idPedido', '=', session()->get('idPedido'))
                            ->get();

            $platillos = $platillos->merge( $platillosPedido );

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

    /**
     * Suma de la cantidad del platillo en pedido
     */
    public function sumar(Sumar $request){
        try {

            $cantidad = PedidoHasPaquete::select('cantidad')
                        ->where('id', '=', $request->id)
                        ->first();

            $cantidad->cantidad = $cantidad->cantidad + 1;

            $PedidoHasPaquete = PedidoHasPaquete::where('id', '=', $request->id)
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
            
            $cantidad = PedidoHasPaquete::select('cantidad')
                        ->where('id', '=', $request->id)
                        ->first();

            $cantidad->cantidad = $cantidad->cantidad - 1;

            if( $cantidad->cantidad == 0 ){

                $PedidoHasPaquete = PedidoHasPaquete::where('id', '=', $request->id);
                $PedidoHasPaquete->delete();

            }else{

                $PedidoHasPaquete = PedidoHasPaquete::where('id', '=', $request->id)
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
}
