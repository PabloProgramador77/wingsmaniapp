<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Domicilio;
use App\Models\Telefono;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\Usuario\Create;
use App\Http\Requests\Usuario\Read;
use App\Http\Requests\Usuario\Update;
use App\Http\Requests\Usuario\Delete;
use App\Http\Requests\Usuario\Edit;
use App\Http\Requests\Usuario\Token;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $usuarios = User::role(['Gerente', 'Mesero'])->get();
            $roles = Role::all();

            return view('usuario.index', compact('usuarios', 'roles'));

        }else{

            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if( auth()->user()->id ){

            if( auth()->user()->hasRole('Cliente') ){

                $cliente = User::find( auth()->user()->id );

                return view('usuario.cliente', compact('cliente'));

            }else{

                $usuario = User::find( auth()->user()->id );
                
                return view('usuario.usuario', compact('usuario'));

            }

        }else{

            return redirect('/');

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {
            
            $usuario = User::create([

                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password)

            ]);

            if( $usuario->id ){

                $usuario->assignRole($request->rol);

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
            
            $usuario = User::find($request->id);

            if( $usuario->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $usuario->name;
                $datos['email'] = $usuario->email;
                $datos['rol'] = $usuario->getRoleNames()->first();
                $datos['id'] = $usuario->id;

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
    public function edit(Edit $request)
    {
        try {
            
            $usuario = User::find( auth()->user()->id );

            if( $usuario->id ){

                $usuario->update([
                    
                    'name' => $request->nombre,
                    'email' => $request->email

                ]);

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {

            $usuario = User::find( $request->id );
            $usuario->name = $request->nombre;
            $usuario->email = $request->email;
            $usuario->save();

            $usuario->assignRole( $request->rol );

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
            
            $usuario = User::find($request->id);

            if( $usuario->id ){

                $usuario->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Carga del TOKEN FCM
     */
    public function token(Token $request){
        try {
            
            $usuario = User::find( $auth()->user()->id );

            if( $usuario->id ){

                $usuario = User::where('id', '=', $auth()->user()->id)
                    ->update([

                        'token' => $request->token

                    ]);

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Descarga del menú en PDF
     */
    public function menu(){
        try {
            
            if( file_exists( public_path('menu_wingsmania.pdf') ) ){

                return response()->download( public_path('menu_wingsmania.pdf') );
                
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
