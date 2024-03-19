@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-user-tag"></i> Roles de Usuarios</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-rol')
                    <x-adminlte-button label="Agregar rol" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/home') }}" class="btn btn-success mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Rol de Usuario', 'Guardia', 'Acciones'

                ];
            @endphp
            
            @can('ver-roles')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="salsas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $roles ) > 0 )
                            @foreach($roles as $role)
                                @can('ver-rol')
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>
                                            @can('editar-rol')
                                                <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $role->id }}" icon="fas fa-pen"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-rol')
                                                <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $role->id }}" icon="fas fa-trash-alt" data-value="{{ $role->name }}"></x-adminlte-button>
                                            @endcan
                                            @if( count($permisos) >0 )
                                                @can('asignar-permisos')
                                                    <x-adminlte-button class="permisos" id="permisos" label="Permisos" theme="secondary" data-id="{{ $role->id }}" icon="fas fa-user-circle" data-toggle="modal" data-target="#modalPermisos" ></x-adminlte-button>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin roles de usuarios registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('roles.nuevo')
    @include('roles.editar')
    @include('roles.permisos')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/role/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/role/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/role/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/role/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/role/permisos.js') }}" type="text/javascript"></script>

@stop