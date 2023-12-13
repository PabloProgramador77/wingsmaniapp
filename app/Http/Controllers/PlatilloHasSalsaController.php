<?php

namespace App\Http\Controllers;

use App\Models\PlatilloHasSalsa;
use Illuminate\Http\Request;
use App\Http\Requests\PlatilloHasSalsa\Store;

class PlatilloHasSalsaController extends Controller
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
    public function store(Store $request)
    {
        try {
            
            foreach($request->salsas as $salsa){

                $platilloHasSalsa = PlatilloHasSalsa::create([

                    'idPlatillo' => $request->id,
                    'idSalsa' => $salsa

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
    public function show(PlatilloHasSalsa $platilloHasSalsa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlatilloHasSalsa $platilloHasSalsa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlatilloHasSalsa $platilloHasSalsa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlatilloHasSalsa $platilloHasSalsa)
    {
        //
    }
}
