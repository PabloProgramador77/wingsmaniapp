@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-truck"></i> Costos de Envio</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-envio')
                    <x-adminlte-button label="Agregar envio" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/home') }}" class="btn btn-success mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Envio', 'Monto', 'Descripción', 'Acciones'

                ];
            @endphp
            
            @can('ver-envios')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="envios" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $envios ) > 0 )
                            @foreach($envios as $envio)
                                @can('ver-envio')
                                    <tr>
                                        <td>{{ $envio->nombre }}</td>
                                        <td>$ {{ $envio->monto }} MXN</td>
                                        <td>{{ $envio->descripcion }}</td>
                                        <td>
                                            @can('editar-envio')
                                                <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $envio->id }}" icon="fas fa-pen"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-envio')
                                                <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $envio->id }}" icon="fas fa-trash-alt" data-value="{{ $envio->nombre }}"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin envios registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('envio.nuevo')
    @include('envio.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/envios/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/envios/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/envios/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/envios/borrar.js') }}" type="text/javascript"></script>

@stop