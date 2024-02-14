<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use App\Http\Requests\Caja\Create;
use App\Http\Requests\Caja\Read;
use App\Http\Requests\Caja\Update;
use App\Http\Requests\Caja\Delete;
use App\Http\Requests\Caja\Abrir;
use App\Http\Requests\Caja\Cerrar;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $cajas = Caja::all();

            return view('cajas.index', compact('cajas'));

        }else{

            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Abrir $request)
    {
        try {
            
            $caja = Caja::where('id', '=', $request->id)
                ->update([

                    'total' => $request->monto,
                    'estatus' => 'Abierta'

                ]);

            $datos['exito'] = true;

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
            
            $caja = Caja::create([

                'nombre' => $request->nombre,
                'total' => $request->total,
                'estatus' => 'Disponible',

            ]);

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
            
            $caja = Caja::find( $request->id );

            if( $caja->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $caja->nombre;
                $datos['total'] = $caja->total;
                $datos['id'] = $caja->id;

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
    public function edit(Cerrar $request)
    {
        try {
            
            $caja = Caja::where('id', '=', $request->id)
                ->update([

                    'estatus' => 'Disponible'

                ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $caja = Caja::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre

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
            
            $caja = Caja::find( $request->id );

            if( $caja->id ){

                $caja->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
