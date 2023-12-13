<?php

namespace App\Http\Controllers;

use App\Models\Preparacion;
use Illuminate\Http\Request;
use App\Http\Requests\Preparacion\Create;
use App\Http\Requests\Preparacion\Read;
use App\Http\Requests\Preparacion\Update;
use App\Http\Requests\Preparacion\Delete;

class PreparacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $preparaciones = Preparacion::all();

            return view('preparacion.index', compact('preparaciones'));

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
            
            $preparacion = Preparacion::create([

                'nombre' => $request->nombre

            ]);

            if( $preparacion->id ){

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
    public function show(Read $request)
    {
        try {
            
            $preparacion = Preparacion::find($request->id);

            if( $preparacion->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $preparacion->nombre;
                $datos['id'] = $preparacion->id;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preparacion $preparacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $preparacion = Preparacion::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre

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
            
            $preparacion = Preparacion::find($request->id);

            if( $preparacion->id ){

                $preparacion->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
