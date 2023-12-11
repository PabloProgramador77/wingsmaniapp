<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\Platillo\Create;
use App\Http\Requests\Platillo\Read;
use App\Http\Requests\Platillo\Update;
use App\Http\Requests\Platillo\Delete;

class PlatilloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $platillos = Platillo::all();
            $categorias = Categoria::all();

            return view('platillo.index', compact('platillos', 'categorias'));

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
            
            $platillo = Platillo::create([

                'nombre' => $request->nombre,
                'precio' => $request->precio,
                'idCategoria' => $request->categoria,
                'descripcion' => $request->descripcion

            ]);

            if( $platillo->id ){

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
            
            $platillo = Platillo::find($request->id);

            if( $platillo->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $platillo->nombre;
                $datos['precio'] = $platillo->precio;
                $datos['idCategoria'] = $platillo->idCategoria;
                $datos['categoria'] = $platillo->categoria->nombre;
                $datos['descripcion'] = $platillo->descripcion;
                $datos['id'] = $platillo->id;

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
    public function edit(Platillo $platillo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $platillo = Platillo::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre,
                    'precio' => $request->precio,
                    'idCategoria' => $request->categoria,
                    'descripcion' => $request->descripcion

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
            
            $platillo = Platillo::find($request->id);

            if( $platillo->id ){

                $platillo->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
