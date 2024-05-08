@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-users"></i> Usuarios de Restaurante</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-usuario')
                    <x-adminlte-button label="Agregar usuario" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/home') }}" class="btn btn-success mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Usuario', 'Rol de Usuario', 'Email', 'Acciones'

                ];
            @endphp
            
            @can('ver-usuarios')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="salsas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $usuarios ) > 0 )
                            @foreach($usuarios as $usuario)
                                @can('ver-usuario')
                                    <tr>
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->getRoleNames()->first() }}</td>
                                        <td>{{ $usuario->email }}</td>
                                        <td>
                                            @can('editar-usuario')
                                                <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $usuario->id }}" icon="fas fa-pen"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-usuario')
                                                <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $usuario->id }}" icon="fas fa-trash-alt" data-value="{{ $usuario->name }}"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin usuarios registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('usuario.nuevo')
    @include('usuario.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuario/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuario/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuario/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/usuario/borrar.js') }}" type="text/javascript"></script>

@stop