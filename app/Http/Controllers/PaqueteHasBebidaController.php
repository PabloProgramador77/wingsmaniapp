<?php

namespace App\Http\Controllers;

use App\Models\PaqueteHasBebida;
use App\Models\Platillo;
use App\Models\Paquete;
use Illuminate\Http\Request;
use App\Http\Requests\PaqueteHasBebida\Create;
use App\Http\Requests\PaqueteHasBebida\Read;

class PaqueteHasBebidaController extends Controller
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
            
            $bebidas = PaqueteHasBebida::where('idPaquete', '=', $request->id)->get();

            if( count( $bebidas ) > 0 ){

                foreach( $bebidas as $bebida ){

                    $bebida->delete();

                }

                foreach( $request->bebidas as $bebida ){

                    $paqueteHasBebida = PaqueteHasBebida::create([

                        'idPaquete' => $request->id,
                        'idBebida' => $bebida

                    ]);

                }

                $datos['exito'] = true;

            }else{

                foreach( $request->bebidas as $bebida ){

                    $paqueteHasBebida = PaqueteHasBebida::create([

                        'idPaquete' => $request->id,
                        'idBebida' => $bebida

                    ]);

                }

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = true;
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
            
            $paquete = Paquete::find( $request->id );

            $bebidas = Platillo::select('platillos.id', 'platillos.nombre')
                    ->join('paquete_has_bebidas', 'platillos.id', '=', 'paquete_has_bebidas.idBebida')
                    ->where('paquete_has_bebidas.idPaquete', '=', $request->id)
                    ->get();

            $datos['exito'] = true;
            $datos['id'] = $paquete->id;
            $datos['nombre'] = $paquete->nombre;
            $datos['platillos'] = $bebidas;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaqueteHasBebida $paqueteHasBebida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaqueteHasBebida $paqueteHasBebida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaqueteHasBebida $paqueteHasBebida)
    {
        //
    }
}
