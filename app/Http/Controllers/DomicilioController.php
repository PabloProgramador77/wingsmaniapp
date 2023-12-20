<?php

namespace App\Http\Controllers;

use App\Models\Domicilio;
use App\Models\ClienteHasDomicilio;
use Illuminate\Http\Request;
use App\Http\Requests\Domicilio\Create;
use App\Http\Requests\Domicilio\Read;
use App\Http\Requests\Domicilio\Update;
use App\Http\Requests\Domicilio\Delete;

class DomicilioController extends Controller
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
            
            $domicilio = Domicilio::create([

                'direccion' => $request->direccion

            ]);

            if( $domicilio->id ){

                $clienteHasDomicilio = ClienteHasDomicilio::create([

                    'idCliente' => auth()->user()->id,
                    'idDomicilio' => $domicilio->id

                ]);

                if( $clienteHasDomicilio->id ){

                    $datos['exito'] = true;

                }

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
            
            $domicilio = Domicilio::find($request->id);

            if( $domicilio->id ){

                $datos['exito'] = true;
                $datos['direccion'] = $domicilio->direccion;
                $datos['id'] = $domicilio->id;

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
    public function edit(Domicilio $domicilio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $domicilio = Domicilio::where('id', '=', $request->id)
                ->update([

                    'direccion' => $request->direccion

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
            
            $domicilio = Domicilio::find($request->id);

            if( $domicilio->id ){

                $domicilio->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
