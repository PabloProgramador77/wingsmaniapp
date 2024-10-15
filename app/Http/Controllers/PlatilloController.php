<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use App\Models\Categoria;
use App\Models\Salsa;
use App\Models\Preparacion;
use Illuminate\Http\Request;
use App\Models\PedidoHasPlatillo;
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

            $platillos = Platillo::orderBy('nombre', 'asc')->get();
            $categorias = Categoria::all();
            $salsas = Salsa::all();
            $preparaciones = Preparacion::all();

            return view('platillo.index', compact('platillos', 'categorias', 'salsas', 'preparaciones'));

        }else{

            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        try {

            $platillo = Platillo::find( $id );
            
            $salsas = $platillo->salsas;
            $preparaciones = $platillo->preparaciones;
            $pedidoHasPlatillo = PedidoHasPlatillo::where('idPlatillo', '=', $id)
                                ->where('idPedido', '=', session()->get('idPedido'))
                                ->first();

            return view('preparar', compact('salsas', 'preparaciones', 'platillo', 'pedidoHasPlatillo'));

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            //return redirect('/');
            
        }
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
                'descripcion' => $request->descripcion,
                'cantidadSalsas' => $request->salsas,
                'portada' => $request->file('portada')->getClientOriginalName(),

            ]);

            if( $platillo->id ){

                $this->subirPortada( $request );

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
                $datos['cantidadSalsas'] = $platillo->cantidadSalsas;
                $datos['salsas'] = $platillo->salsas;
                $datos['portada'] = $platillo->portada;
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
                    'descripcion' => $request->descripcion,
                    'cantidadSalsas' => $request->salsas,
                    'portada' => $request->file('portada')->getClientOriginalName(),

                ]);

            $this->subirPortada( $request );

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
