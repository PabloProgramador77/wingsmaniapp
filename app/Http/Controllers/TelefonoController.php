<?php

namespace App\Http\Controllers;

use App\Models\Telefono;
use App\Models\ClienteHasTelefono;
use Illuminate\Http\Request;
use App\Http\Requests\Telefono\Create;
use App\Http\Requests\Telefono\Read;
use App\Http\Requests\Telefono\Update;
use App\Http\Requests\Telefono\Delete;

class TelefonoController extends Controller
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
            
            $telefono = Telefono::create([

                'nunmero' => $request->telefono

            ]);

            if( $telefono->id ){

                $clienteHasTelefono = ClienteHasTelefono::create([

                    'idCliente' => auth()->user()->id,
                    'idTelefono' => $telefono->id

                ]);

                if( $clienteHasTelefono->id ){

                    $datos['exito'] = true;

                }

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = true;
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
            
            $telefono = Telefono::find($request->id);

            if( $telefono->id ){

                $datos['exito'] = true;
                $datos['telefono'] = $telefono->nunmero;
                $datos['id'] = $telefono->id;

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
    public function edit(Telefono $telefono)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $telefono = Telefono::where('id', '=', $request->id)
                ->update([

                    'nunmero' => $request->telefono

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
            
            $telefono = Telefono::find($request->id);

            if( $telefono->id ){

                $telefono->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
