<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Categoria;
use App\Models\Platillo;
use Illuminate\Http\Request;
use App\Http\Requests\Paquete\Create;
use App\Http\Requests\Paquete\Read;
use App\Http\Requests\Paquete\Update;
use App\Http\Requests\Paquete\Delete;

class PaqueteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $paquetes = Paquete::all();
            $categorias = Categoria::all();
            $platillos = Platillo::all();

            return view('platillo.paquetes.index', compact('paquetes', 'categorias', 'platillos'));

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
            
            $paquete = Paquete::create([

                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'descripcion' => $request->descripcion,
                'cantidadBebidas' => $request->bebidas,
                'cantidadSalsas' => $request->salsas,
                'idCategoria' => $request->categoria

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
    public function show(Read $request)
    {
        try {
            
            $paquete = Paquete::find( $request->id );

            if( $paquete->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $paquete->nombre;
                $datos['precio'] = $paquete->precio;
                $datos['idCategoria'] = $paquete->categoria->id;
                $datos['categoria'] = $paquete->categoria->nombre;
                $datos['salsas'] = $paquete->cantidadSalsas;
                $datos['bebidas'] = $paquete->cantidadBebidas;
                $datos['descripcion'] = $paquete->descripcion;
                $datos['id'] = $paquete->id;

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
    public function edit(Paquete $paquete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $paquete = Paquete::where('id', '=', $request->id)
                    ->update([

                    'nombre' => $request->nombre,
                    'precio' => $request->precio,
                    'descripcion' => $request->descripcion,
                    'cantidadBebidas' => $request->bebidas,
                    'cantidadSalsas' => $request->salsas,
                    'idCategoria' => $request->categoria

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
            
            $paquete = Paquete::find ( $request->id );

            if( $paquete->id ){

                $paquete->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
