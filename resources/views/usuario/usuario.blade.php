@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-user"></i> Perfil de Usuario</h4>
            </div>

        </div>

        <div class="container-fluid col-md-12 row p-2">

            <div class="col-md-5 m-1 p-2 rounded shadow">
                <div class="form-group">
                    <img src="{{ url('img/logo_min.png') }}" alt="" width="200px" height="200px" class="p-2 rounded m-auto d-block">
                    <p class="text-center" style="font-size: 24px;"><b>{{ $usuario->name }}</b></p>
                    <p class="text-center text-secondary" style="font-size: 18px;">{{ $usuario->email }}</p>
                </div>
            </div>

            <div class="col-md-6 m-1 p-2">
                <form novalidate>
                    <div class="form-group">
                        <x-adminlte-input name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario" value="{{ $usuario->name }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-warning">
                                    <i class="fas fa-user"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="emailUsuario" id="emailUsuario" placeholder="Email de usuario" value="{{ $usuario->email }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-warning">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="form-group">
                        @can('editar-perfil')
                            <x-adminlte-button theme="primary" label="Guardar cambios" id="actualizar" icon="fas fa-save"></x-adminlte-button>
                        @endcan
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuario/perfil.js') }}" type="text/javascript"></script>
    
@stop