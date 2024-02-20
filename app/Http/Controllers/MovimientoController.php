<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Caja;
use Illuminate\Http\Request;
use App\Http\Requests\Movimiento\Create;
use App\Http\Requests\Movimiento\Read;
use App\Http\Requests\Movimiento\Update;
use App\Http\Requests\Movimiento\Delete;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idCaja)
    {
        try {
            
            $movimientos = Movimiento::where('idCaja', '=', $idCaja)->get();
            $caja = Caja::find( $idCaja );

            return view('cajas.movimientos.index', compact('movimientos', 'caja'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {
            
            $movimiento = Movimiento::create([

                'concepto' => $request->concepto,
                'tipo' => $request->tipo,
                'monto' => $request->monto,
                'idCaja' => $request->idCaja

            ]);

            $this->edit( $request, 'store' );

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Display the specified resource.
     */
    public function show(Read $request)
    {
        try {
            
            $movimiento = Movimiento::find( $request->id );

            if( $movimiento->id ){

                $datos['exito'] = true;
                $datos['concepto'] = $movimiento->concepto;
                $datos['tipo'] = $movimiento->tipo;
                $datos['monto'] = $movimiento->monto;
                $datos['id'] = $movimiento->id;

            }

        } catch (\Throwable $th) {

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $tipoRequest)
    {
        try {

            switch ($tipoRequest) {
                
                case 'store':
                    
                    $caja = Caja::find( $request->idCaja );

                    if( $request->tipo == 'Deposito' ){

                        $caja->total += $request->monto;

                    }else{

                        $caja->total -= $request->monto;

                    }

                    $caja->save();

                    break;

                case 'update':

                    $caja = Caja::find( $request->idCaja );
                    $movimiento = Movimiento::find( $request->id );

                    if( $request->tipo =='Deposito' ){

                        $caja->total -= $movimiento->monto;
                        $caja->total += $request->monto;

                    }else{

                        $caja->total += $movimiento->monto;
                        $caja->total -= $request->monto;

                    }

                    $caja->save();

                    break;

                case 'delete':

                    $caja = Caja::find( $request->idCaja );
                    $movimiento = Movimiento::find( $request->id );

                    if( $movimiento->tipo == 'Deposito' ){

                        $caja->total -= $movimiento->monto;

                    }else{

                        $caja->total += $movimiento->monto;

                    }

                    $caja->save();

                    break;

            }

        } catch (\Throwable $th) {
            
            echo "Error: ".$th->getMessage();

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {

            $this->edit( $request, 'update' );
            
            $movimiento = Movimiento::where('id', '=', $request->id)
                ->update([

                    'concepto' => $request->concepto,
                    'tipo' => $request->tipo,
                    'monto' => $request->monto

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
            
            $movimiento = Movimiento::find( $request->id );

            if( $movimiento->id ){

                $this->edit( $request, 'delete' );

                $movimiento->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
