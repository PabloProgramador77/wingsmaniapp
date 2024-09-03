<?php

namespace App\Http\Controllers;

use App\Models\PlatilloHasPreparacion;
use App\Models\Platillo;
use Illuminate\Http\Request;
use App\Http\Requests\PlatilloHasPreparacion\Create;

class PlatilloHasPreparacionController extends Controller
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
            
            foreach($request->preparaciones as $preparacion){

                $platillo_has_preparacion = PlatilloHasPreparacion::create([

                    'idPlatillo' => $request->id,
                    'idPreparacion' => $preparacion

                ]);

            }

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            
            $platillo = Platillo::find( $request->id );

            if( $platillo && $platillo->id ){

                $datos['exito'] = true;
                $datos['preparaciones'] = $platillo->preparaciones;

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
    public function edit(PlatilloHasPreparacion $platilloHasPreparacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlatilloHasPreparacion $platilloHasPreparacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlatilloHasPreparacion $platilloHasPreparacion)
    {
        //
    }
}
