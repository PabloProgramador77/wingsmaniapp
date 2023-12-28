<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Requests\Pedido\Create;

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
        //
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
    public function show(Pedido $pedido)
    {
        //
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
    public function destroy(Pedido $pedido)
    {
        //
    }
}
