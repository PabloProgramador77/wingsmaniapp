<?php

namespace App\Http\Controllers;

use App\Models\Salsa;
use Illuminate\Http\Request;
use App\Http\Requests\Salsa\Create;
use App\Http\Requests\Salsa\Read;
use App\Http\Requests\Salsa\Update;
use App\Http\Requests\Salsa\Delete;

class SalsaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $salsas = Salsa::all();

            return view('salsa.index', compact('salsas'));

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
            
            $salsa = Salsa::create([

                'nombre' => $request->nombre

            ]);

            if( $salsa->id ){

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

            $salsa = Salsa::find($request->id);

            if( $salsa->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $salsa->nombre;
                $datos['id'] = $salsa->id;

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
    public function edit(Salsa $salsa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $salsa = Salsa::where('id', '=', $request->id)
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
            
            $salsa = Salsa::find($request->id);

            if( $salsa->id ){

                $salsa->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
