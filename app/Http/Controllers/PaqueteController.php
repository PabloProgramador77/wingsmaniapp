<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Categoria;
use App\Models\Platillo;
use App\Models\Salsa;
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
            $platillos = Platillo::orderBy('nombre', 'asc')->get();
            $salsas = Salsa::all();

            return view('platillo.paquetes.index', compact('paquetes', 'categorias', 'platillos', 'salsas'));

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
                'platillosEditables' => $request->editables,
                'idCategoria' => $request->categoria,
                'diaActivacion' => $request->dia,
                'portada' => $request->file('portada')->getClientOriginalName(),

            ]);

            $this->subirPortada( $request );

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

                $platillos = Platillo::select('platillos.id', 'platillos.nombre')
                            ->join('paquete_has_platillos', 'platillos.id', '=', 'paquete_has_platillos.idPlatillo')
                            ->where('paquete_has_platillos.idPaquete', '=', $paquete->id)
                            ->orderBy('platillos.nombre', 'asc')
                            ->get();

                $datos['exito'] = true;
                $datos['nombre'] = $paquete->nombre;
                $datos['precio'] = $paquete->precio;
                $datos['idCategoria'] = $paquete->categoria->id;
                $datos['categoria'] = $paquete->categoria->nombre;
                $datos['salsas'] = $paquete->cantidadSalsas;
                $datos['bebidas'] = $paquete->cantidadBebidas;
                $datos['editables'] = $paquete->platillosEditables;
                $datos['descripcion'] = $paquete->descripcion;
                $datos['dia'] = $paquete->diaActivacion;
                $datos['id'] = $paquete->id;
                $datos['platillos'] = $platillos;
                $datos['portada'] = $paquete->portada;

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
                    'platillosEditables' => $request->editables,
                    'idCategoria' => $request->categoria,
                    'diaActivacion' => $request->dia,
                    'portada' => $request->file('portada')->getClientOriginalName(),

            ]);

            $this->subirPortada( $request );

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

    /**
     * Subida de portada
     */
    public function subirPortada( Request $request ){
        try {
            
            if( file_exists( public_path('img/portadas/') ) ){

                $request->file('portada')->move( public_path('img/portadas'), $request->file('portada')->getClientOriginalName() );

                if( file_exists( public_path('img/portadas/').$request->file('portada')->getClientOriginalName() ) ){

                    return true;

                }else{

                    return false;

                }

            }else{

                mkdir( public_path('img/portadas') );

                $request->file('portada')->move( public_path('img/portadas'), $request->file('portada')->getClientOriginalName() );

                if( file_exists( public_path('img/portadas/').$request->file('portada')->getClientOriginalName() ) ){

                    return true;

                }else{

                    return false;
                    
                }

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }
}
