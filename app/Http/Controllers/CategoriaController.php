<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Platillo;
use App\Models\Pedido;
use App\Models\Paquete;
use Illuminate\Http\Request;
use App\Http\Requests\Categoria\Store;
use App\Http\Requests\Categoria\Search;
use App\Http\Requests\Categoria\Update;
use App\Http\Requests\Categoria\Delete;
use Carbon\Carbon;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $categorias = Categoria::all();

            return view('categoria.index', compact('categorias'));

        }else{

            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        if( auth()->user()->id && session()->get('idPedido') ){

            $hoy = Carbon::now()->locale('es')->translatedFormat('l');

            $platillos = Platillo::select('id', 'nombre', 'precio', 'cantidadSalsas')
                        ->where('idCategoria', '=', $id)
                        ->orderBy('nombre', 'asc')
                        ->get();

            $paquetes = Paquete::select('id', 'nombre', 'precio', 'cantidadBebidas', 'cantidadSalsas', 'platillosEditables')
                        ->where('idCategoria', '=', $id)
                        ->where('diaActivacion', '=', NULL)
                        ->get();

            $paquetesHoy = Paquete::select('id', 'nombre', 'precio', 'cantidadBebidas', 'cantidadSalsas', 'platillosEditables')
                        ->where('idCategoria', '=', $id)
                        ->where('diaActivacion', '=', $hoy)
                        ->get();

            $paquetes = $paquetes->merge( $paquetesHoy )->unique('id');

            $categoria = Categoria::find($id);

            $pedido = Pedido::find(session()->get('idPedido'));
            
            $platillosPedido = Platillo::select('pedido_has_platillos.id', 'pedido_has_platillos.cantidad', 'pedido_has_platillos.preparacion', 'platillos.nombre')
                ->join('pedido_has_platillos', 'platillos.id', '=', 'pedido_has_platillos.idPlatillo')
                ->where('pedido_has_platillos.idPedido', '=', session()->get('idPedido'))
                ->get();

            $paquetesPedido = Paquete::select('pedido_has_paquetes.id', 'pedido_has_paquetes.cantidad', 'pedido_has_paquetes.preparacion', 'paquetes.nombre')
                            ->join('pedido_has_paquetes', 'paquetes.id', '=', 'pedido_has_paquetes.idPaquete')
                            ->where('pedido_has_paquetes.idPedido', '=', session()->get('idPedido'))
                            ->get();

            return view('carta', compact('platillos', 'categoria', 'pedido', 'platillosPedido', 'paquetes', 'paquetesPedido'));

        }else{

            return redirect('/');

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        try {
            
            $categoria = Categoria::create([

                'nombre' => $request->nombre,
                'portada' => $request->file('portada')->getClientOriginalName(),

            ]);

            if( $categoria->id ){

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
    public function show(Search $request)
    {
        try {
            
            $categoria = Categoria::find($request->id);

            if( $categoria->id ){

                $datos['exito'] = true;
                $datos['id'] = $categoria->id;
                $datos['nombre'] = $categoria->nombre;
                $datos['portada'] = $categoria->portada;

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
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $categoria = Categoria::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre,
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
            
            $categoria = Categoria::find($request->id);

            if( $categoria->id ){

                $categoria->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Subida de imagen de portada
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
