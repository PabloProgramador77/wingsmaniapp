<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\Usuario\Create;
use App\Http\Requests\Usuario\Read;
use App\Http\Requests\Usuario\Update;
use App\Http\Requests\Usuario\Delete;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $usuarios = User::all();
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
        //
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
                $datos['rol'] = $usuario->getRoleNames();
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $usuario = User::where('id', '=', $request->id)
                ->update([

                    'name' => $request->nombre,
                    'email' => $request->email

                ]);

            $usuario->assignRole($request->rol);

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
}
