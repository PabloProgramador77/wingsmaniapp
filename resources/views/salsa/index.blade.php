@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-pepper-hot"></i> Salsas de Platillos</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-salsa')
                    <x-adminlte-button label="Agregar salsa" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
            </div>

            @php
                $heads = [

                    'Salsa', 'Acciones'

                ];
            @endphp
            
            @can('ver-salsas')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="salsas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $salsas ) > 0 )
                            @foreach($salsas as $salsa)
                                @can('ver-salsa')
                                    <tr>
                                        <td>{{ $salsa->nombre }}</td>
                                        <td>
                                            @can('editar-salsa')
                                                <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $salsa->id }}" icon="fas fa-pen"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-salsa')
                                                <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $salsa->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin salsas registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('salsa.nuevo')
    @include('salsa.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/salsa/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/salsa/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/salsa/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/salsa/borrar.js') }}" type="text/javascript"></script>

@stop