@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-map-marker-alt"></i> Tus Domicilios</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-smile"></i> Panel de Cliente</p>
                <p class="p-1 bg-light text-center fw-semibold">Elige el domicilio en el que deseas recibir el pedido. Pulsa el botón con el icono <i class="fas fa-map-marker-alt"></i></p>
            </div>

            @php
                $heads = [

                    'Domicilio(s)', 'Recibir aquí'

                ];
            @endphp
            
            @can('ver-domicilios')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="salsas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $domicilios ) > 0 )
                            @foreach($domicilios as $domicilio)
                                @can('ver-domicilio')
                                    <tr>
                                        <td>{{ $domicilio->direccion }}</td>
                                        <td>
                                            <x-adminlte-button class="entregar" id="entregar" title="Entregar Aquí" theme="info" data-id="{{ $domicilio->id }}" icon="fas fa-map-marker-alt"></x-adminlte-button>
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin domicilios registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/entregar.js') }}" type="text/javascript"></script>
    
@stop