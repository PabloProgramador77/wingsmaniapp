<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\Pedido\Create;
use App\Http\Requests\Pedido\Delete;

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
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
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
