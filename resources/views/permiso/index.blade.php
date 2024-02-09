@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-user-circle"></i> Permisos de Usuarios</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-permiso')
                    <x-adminlte-button label="Agregar permiso" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
            </div>

            @php
                $heads = [

                    'Permiso de Usuario', 'Guardia', 'Acciones'

                ];
            @endphp
            
            @can('ver-permisos')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="salsas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $permisos ) > 0 )
                            @foreach($permisos as $permiso)
                                @can('ver-permiso')
                                    <tr>
                                        <td>{{ $permiso->name }}</td>
                                        <td>{{ $permiso->guard_name }}</td>
                                        <td>
                                            @can('editar-permiso')
                                                <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $permiso->id }}" icon="fas fa-pen"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-permiso')
                                                <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $permiso->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin permisos de usuarios registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('permiso.nuevo')
    @include('permiso.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permiso/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permiso/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permiso/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/permiso/borrar.js') }}" type="text/javascript"></script>

@stop