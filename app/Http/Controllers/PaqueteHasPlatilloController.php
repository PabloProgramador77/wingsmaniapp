<?php

namespace App\Http\Controllers;

use App\Models\PaqueteHasPlatillo;
use App\Models\Paquete;
use Illuminate\Http\Request;
use App\Http\Requests\PaqueteHasPlatillo\Create;

class PaqueteHasPlatilloController extends Controller
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

            $platillos = PaqueteHasPlatillo::where('idPaquete', '=', $request->id )->get();

            if( count( $platillos ) > 0 ){

                foreach( $platillos as $platillo ){

                    $platillo->delete();

                }

                if( count( $request->platillos ) > 0 ){

                    foreach( $request->platillos as $platillo ){
    
                        $paqueteHasPlatillo = PaqueteHasPlatillo::create([
    
                            'idPaquete' => $request->id,
                            'idPlatillo' => $platillo
    
                        ]);
    
                    }
    
                    $datos['exito'] = true;
    
                }

            }else{

                if( count( $request->platillos ) > 0 ){

                    foreach( $request->platillos as $platillo ){
    
                        $paqueteHasPlatillo = PaqueteHasPlatillo::create([
    
                            'idPaquete' => $request->id,
                            'idPlatillo' => $platillo
    
                        ]);
    
                    }
    
                    $datos['exito'] = true;
    
                }

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Display the specified resource.
     */
    public function show( Request $request)
    {
        try {
            
            $paquete = Paquete::find( $request->id );

            if( $paquete->id ){

                $datos['exito'] = true;
                $datos['platillos'] = $paquete->platillos;
                $datos['bebidas'] = $paquete->bebidas;

                foreach( $datos['platillos'] as $platillo ){

                    if( count( $platillo->salsas ) > 0 ){

                        $platillo->salsas = $platillo->salsas;

                    }

                    if( count( $platillo->preparaciones ) > 0 ){

                        $platillo->preparaciones = $platillo->preparaciones;
                        
                    }

                }

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
    public function edit(PaqueteHasPlatillo $paqueteHasPlatillo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaqueteHasPlatillo $paqueteHasPlatillo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaqueteHasPlatillo $paqueteHasPlatillo)
    {
        //
    }
}
