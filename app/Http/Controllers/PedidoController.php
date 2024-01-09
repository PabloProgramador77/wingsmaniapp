<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Domicilio;
use Illuminate\Http\Request;
use App\Http\Requests\Pedido\Create;
use App\Http\Requests\Pedido\Delete;
use App\Http\Requests\Pedido\Ordenar;
use App\Http\Requests\Pedido\Entregar;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id && !auth()->User()->hasRole('Cliente') ){

            $pedidos = Pedido::where('estatus', '=', 'Abierto')
                ->orderBy('created_at', 'asc')
                ->get();

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
                'estatus' => 'Abierto',
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

                $pedidos = Pedido::where('idCliente', '=', auth()->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

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

                    session()->forget('idPedido');

                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Pedido Enviado a Restaurante.';
                    $datos['url'] = '/pedidos/cliente';

                    //Crear comanda y enviar notificación

                }else{

                    if( count( auth()->user()->domicilios ) > 0 ){

                        if( count( auth()->user()->domicilios ) == 1 ){

                            session()->forget('idPedido');

                            $datos['exito'] = true;
                            $datos['mensaje'] = 'Pedido Enviado a Restaurante.';
                            $datos['url'] = '/pedidos/cliente';

                            //Crear comanda y enviar notificación

                        }else{

                            $datos['exito'] = true;
                            $datos['mensaje'] = 'Elige el domicilio para entregar tu pedido.';
                            $datos['url'] = '/pedido/domicilios';

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

                session()->forget('idPedido');

                $datos['exito'] = true;

                //Enviar notificación
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

}
