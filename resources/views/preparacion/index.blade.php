@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-utensils"></i> Preparaciones de Platillos</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-preparacion')
                    <x-adminlte-button label=" preparación" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/home') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Preparación', 'Acciones'

                ];
            @endphp
            
            @can('ver-preparaciones')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="preparacions" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $preparaciones ) > 0 )
                            @foreach($preparaciones as $preparacion)
                                @can('ver-preparacion')
                                    <tr>
                                        <td>{{ $preparacion->nombre }}</td>
                                        <td>
                                            @can('editar-preparacion')
                                                <x-adminlte-button class="editar" id="editar"  theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $preparacion->id }}" icon="fas fa-edit"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-preparacion')
                                                <x-adminlte-button class="eliminar" id="eliminar"  theme="danger" data-id="{{ $preparacion->id }}" icon="fas fa-trash-alt" data-value="{{ $preparacion->nombre }}"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin preparaciones registradas</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('preparacion.nuevo')
    @include('preparacion.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/preparacion/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/preparacion/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/preparacion/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/preparacion/borrar.js') }}" type="text/javascript"></script>

@stop