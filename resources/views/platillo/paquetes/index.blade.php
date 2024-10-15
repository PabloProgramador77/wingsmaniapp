@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-drumstick-bite"></i> Paquetes / Promociones</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-5">
                @can('agregar-platillo')
                    <x-adminlte-button id="nuevo" label="Paquete" theme="info" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/platillos') }}" class="btn btn-primary mx-1 rounded"><i class="fas fa-drumstick-bite"></i> Platillos</a>
                <a href="{{ url('/home') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Categoría', 'Paquete / Promoción', 'Precio', 'Acciones'

                ];
            @endphp
            
            @can('ver-platillos')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="platillos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $paquetes ) > 0 )
                            @foreach($paquetes as $paquete)
                                @can('ver-platillo')
                                    <tr>
                                        <td>{{ $paquete->categoria->nombre }}</td>
                                        <td>{{ $paquete->nombre }}</td>
                                        <td>$ {{ $paquete->precio }}</td>
                                        <td>
                                            @can('editar-platillo')
                                                <x-adminlte-button class="editar" id="editar"  theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $paquete->id }}" icon="fas fa-edit"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-platillo')
                                                <x-adminlte-button class="eliminar" id="eliminar"  theme="danger" data-id="{{ $paquete->id }}" icon="fas fa-trash-alt" data-value="{{ $paquete->nombre }}"></x-adminlte-button>
                                            @endcan
                                            @if( count($platillos) > 0 )
                                                @can('ver-platillos')
                                                    <x-adminlte-button class="platillos" id="platillos" theme="primary" data-id="{{ $paquete->id }}" icon="fas fa-drumstick-bite" data-toggle="modal" data-target="#modalPlatillos"></x-adminlte-button>
                                                @endcan
                                            @endif
                                            @if ( $paquete->cantidadBebidas > 0 )
                                                @can('ver-platillos')
                                                    <x-adminlte-button class="bebidas" id="bebidas" theme="secondary" data-id="{{ $paquete->id }}" icon="fas fa-wine-bottle" data-toggle="modal" data-target="#modalBebidas"></x-adminlte-button>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin paquetes registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('platillo.paquetes.nuevo')
    @include('platillo.paquetes.editar')
    @include('platillo.paquetes.platillos')
    @include('platillo.paquetes.bebidas')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/paquete/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/paquete/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/paquete/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/paquete/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/paquete/platillos.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/paquete/agregarBebida.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/paquete/image.js') }}" type="text/javascript"></script>

@stop