<?php

namespace App\Http\Controllers;

use App\Models\PlatilloHasAderezo;
use Illuminate\Http\Request;
use App\Http\Requests\PlatilloHasAderezos\Create;
use App\Models\Aderezo;

class PlatilloHasAderezoController extends Controller
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
            
            $aderezos = PlatilloHasAderezo::where('idPlatillo', '=', $request->id)
                    ->get();

            if( count( $aderezos ) > 0){

                foreach( $aderezos as $aderezo ){

                    $aderezo->delete();

                }

                foreach( $request->aderezos as $pa ){

                    $platilloHasAderezo = PlatilloHasAderezo::create([

                        'idPlatillo' => $request->id,
                        'idAderezo' => $pa,

                    ]);

                }

                $datos['exito'] = true;

            }else{

                foreach( $request->aderezos as $pa ){

                    $platilloHasAderezo = PlatilloHasAderezo::create([

                        'idPlatillo' => $request->id,
                        'idAderezo' => $pa,

                    ]);

                }

                $datos['exito'] = true;

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
    public function show(PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }
}
