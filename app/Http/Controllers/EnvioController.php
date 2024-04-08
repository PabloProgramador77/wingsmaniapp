<?php

namespace App\Http\Controllers;

use App\Models\Envio;
use Illuminate\Http\Request;
use App\Http\Requests\Envio\Create;
use App\Http\Requests\Envio\Read;
use App\Http\Requests\Envio\Update;
use App\Http\Requests\Envio\Delete;

class EnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $envios = Envio::all();

            return view('envio.index', compact('envios'));

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
            
            $envio = Envio::create([

                'nombre' => $request->nombre,
                'monto' => $request->monto,
                'descripcion' => $request->descripcion

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
            
            $envio = Envio::find( $request->id );

            if( $envio->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $envio->nombre;
                $datos['monto'] = $envio->monto;
                $datos['descripcion'] = $envio->descripcion;
                $datos['id'] = $envio->id;

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
    public function edit(Envio $envio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $envio = Envio::where('id', '=', $request->id)
                    ->update([

                        'nombre' => $request->nombre,
                        'monto' => $request->monto,
                        'descripcion' => $request->descripcion

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
            
            $envio = Envio::find( $request->id );

            if( $envio->id ){

                $envio->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
