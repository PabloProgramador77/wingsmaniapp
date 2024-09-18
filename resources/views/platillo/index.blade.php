@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-drumstick-bite"></i> Platillos</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-5">
                @can('agregar-platillo')
                    <x-adminlte-button id="nuevo" label="Platillo" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/paquetes') }}" class="btn btn-info mx-1 rounded"><i class="fas fa-boxes"></i> Paquetes</a>
                <a href="{{ url('/home') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Platillo', 'Precio', 'Acciones'

                ];
            @endphp
            
            @can('ver-platillos')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="platillos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $platillos ) > 0 )
                            @foreach($platillos as $platillo)
                                @can('ver-platillo')
                                    <tr>
                                        <td>{{ $platillo->nombre }}</td>
                                        <td>$ {{ $platillo->precio }} M.N.</td>
                                        <td>
                                            @can('editar-platillo')
                                                <x-adminlte-button class="editar" id="editar"  theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $platillo->id }}" icon="fas fa-edit"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-platillo')
                                                <x-adminlte-button class="eliminar" id="eliminar"  theme="danger" data-id="{{ $platillo->id }}" icon="fas fa-trash-alt" data-value="{{ $platillo->nombre }}"></x-adminlte-button>
                                            @endcan
                                            @if( count($salsas) > 0 && $platillo->cantidadSalsas > 0)
                                                @can('ver-salsas')
                                                    <x-adminlte-button class="salsas" id="salsas" theme="secondary" data-id="{{ $platillo->id }}" icon="fas fa-pepper-hot" data-toggle="modal" data-target="#modalSalsa"></x-adminlte-button>
                                                @endcan
                                            @endif
                                            @if( count($preparaciones) > 0 )
                                                @can('ver-preparaciones')
                                                    <x-adminlte-button class="preparaciones" id="preparaciones" theme="success" data-id="{{ $platillo->id }}" icon="fas fa-utensils" data-toggle="modal" data-target="#modalPreparacion"></x-adminlte-button>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin platillos registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('platillo.nuevo')
    @include('platillo.editar')
    @include('platillo.salsas')
    @include('platillo.preparaciones')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/image.js') }}" type="text/javascript"></script>
    @if( count($categorias) > 0 )
        <script src="{{ asset('js/platillo/agregar.js') }}" type="text/javascript"></script>
    @else
        <script src="{{ asset('js/platillo/noAgregar.js') }}" type="text/javascript"></script>
    @endif

    @if( count($salsas) > 0 )
        <script src="{{ asset('js/platillo/salsas.js') }}" type="text/javascript"></script>
    @endif

    @if( count($preparaciones) > 0 )
        <script src="{{ asset('js/platillo/preparaciones.js') }}" type="text/javascript"></script>
    @endif

@stop