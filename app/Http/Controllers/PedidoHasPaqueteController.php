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
    public function create( $id )
    {
        try {
            
            if( session()->get('idPedidoPaquete') ){
    
                $paquete = Paquete::find( $id );
                $pedidoHasPaquete = PedidoHasPaquete::find( session()->get('idPedidoPaquete') );

                return view('promo', compact( 'paquete', 'pedidoHasPaquete' ));

            }else{

                $pedidoHasPaquete = PedidoHasPaquete::create([

                    'idPedido' => session()->get('idPedido'),
                    'idPaquete' => $id,
                    'cantidad' => 1,
    
                ]);
    
                $pedido = Pedido::find( session()->get('idPedido') );
    
                $paquete = Paquete::find( $id );
    
                $totalPedido = $this->total();

                session()->put('idPedidoPaquete', $pedidoHasPaquete->id);
                session()->put('conteoPlatillo', $paquete->platillosEditables);
    
                return view('promo', compact( 'paquete', 'pedidoHasPaquete' ));

            }
            

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( $id, $idPlatillo )
    {
        try {
            
            $pedidoHasPaquete = PedidoHasPaquete::find( $id );

            if( $pedidoHasPaquete->id ){

                $platillo = Platillo::find( $idPlatillo );
                $paquete = Paquete::find( $pedidoHasPaquete->idPaquete );

                return view('paquete', compact('platillo', 'paquete', 'pedidoHasPaquete'));

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Display the specified resource.
     */
    public function show( $idPaquete )
    {
        try {
            
            $paquete = Paquete::find( $idPaquete );

            if( $paquete->id ){

                return view('bebida', compact('paquete'));

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
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

            if( session()->get('conteoPlatillo') ){

                $conteo = session()->get('conteoPlatillo');

                $preparacion = PedidoHasPaquete::select('pedido_has_paquetes.preparacion')
                            ->where('id', '=', $request->id)->first();

                $pedidoHasPaquete = PedidoHasPaquete::where('id', '=', $request->id )
                                    ->update([

                                        'preparacion' => $preparacion->preparacion.' '.$request->preparaciones

                ]);

                $conteo--;
                
                session()->put('conteoPlatillo', $conteo);

                $datos['exito'] = true;

            }else{

                $preparacion = PedidoHasPaquete::select('pedido_has_paquetes.preparacion')
                            ->where('id', '=', $request->id)->first();

                $pedidoHasPaquete = PedidoHasPaquete::where('id', '=', $request->id )
                                    ->update([

                                        'preparacion' => $preparacion->preparacion.' '.$request->preparaciones

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
