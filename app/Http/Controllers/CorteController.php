<?php

namespace App\Http\Controllers;

use App\Models\Corte;
use App\Models\Caja;
use App\Models\Pedido;
use App\Models\CorteHasPedidos;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use App\Http\Requests\Corte\Calcular;
use App\Http\Requests\Corte\Create;
use App\Http\Requests\Corte\Delete;
use App\Http\Requests\Corte\Read;

class CorteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idCaja)
    {
        try {
            
            if( auth()->user()->id ){

                $caja = Caja::find( $idCaja );
                $cortes = Corte::all();

                return view('cajas.cortes.index', compact('cortes', 'caja'));

            }else{

                return redirect('/');

            }

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Calcular $request)
    {
        try {
            
            $total = 0;
            $pedidos = Pedido::where('estatus', '=', 'Pagado')->get();

            foreach($pedidos as $pedido){

                $total += $pedido->total;

            }

            if( $total > 0 ){

                $datos['exito'] = true;
                $datos['total'] = $total;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Monto insuficiente.';

            }

            

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {

            $pedidos = Pedido::where('estatus', '=', 'Pagado')->get();

            if( count($pedidos) > 0 ){

                $corte = Corte::create([

                    'nombre' => $request->nombre,
                    'total' => $request->total,
                    'idCaja' => $request->idCaja
    
                ]);

                $corte = Corte::latest()->first();

                foreach($pedidos as $pedido){

                    $corteHasPed = CorteHasPedidos::create([

                        'idCorte' => $corte->id,
                        'idPedido' => $pedido->id

                    ]);

                    $pedido->estatus = 'Corte';
                    $pedido->save();

                }

                $movimiento = Movimiento::create([

                    'concepto' => $corte->nombre,
                    'tipo' => 'Corte',
                    'monto' => $corte->total,
                    'idCaja' => $corte->idCaja

                ]);

                if( $movimiento->id ){

                    $caja = Caja::find( $movimiento->idCaja );
                    $caja->total += $movimiento->monto;
                    $caja->save();
                    
                }

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Display the specified resource.
     */
    public function show($idCorte)
    {
        try {
            
            $corte = Corte::find( $idCorte );

            $pedidos = Pedido::select('pedidos.id', 'pedidos.total', 'pedidos.tipo', 'pedidos.idCliente')
                ->join('corte_has_pedidos', 'pedidos.id', '=', 'corte_has_pedidos.idPedido')
                ->where('corte_has_pedidos.idCorte', '=', $idCorte)
                ->get();

            return view('cajas.cortes.corte', compact('corte', 'pedidos'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Corte $corte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Corte $corte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $corte = Corte::find( $request->id );

            if( $corte->id ){

                $corte->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
