<?php

namespace App\Http\Controllers;

use App\Models\Aderezo;
use Illuminate\Http\Request;
use App\Http\Requests\Aderezos\Create;
use App\Http\Requests\Aderezos\Update;
use App\Http\Requests\Aderezos\Delete;

class AderezoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $aderezos = Aderezo::all();

            return view('aderezos.index', compact('aderezos'));

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

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
            
            $aderezo = Aderezo::create([

                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,

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
    public function show(Aderezo $aderezo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aderezo $aderezo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $aderezo = Aderezo::where('id', '=', $request->id)
                    ->update([

                        'nombre' => $request->nombre,
                        'descripcion' => $request->descripcion,

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
            
            $aderezo = Aderezo::find( $request->id );

            if( $aderezo && $aderezo->id ){

                $aderezo->delete();

                $datos['exito'] = true;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Aderezo no identificado';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
