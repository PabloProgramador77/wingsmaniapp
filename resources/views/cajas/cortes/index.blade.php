@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-money-bill"></i> Cortes de Caja - {{ $caja->nombre }}</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
                <input type="hidden" name="idCaja" id="idCaja" value="{{ $caja->id }}">
            </div>
            @can('agregar-corte')
                <div class="col-md-3">
                    <x-adminlte-button label="Nuevo corte" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle" id="nuevo"></x-adminlte-button>
                </div>
            @endcan

            @php
                $heads = [

                    'Corte', 'Monto', 'Fecha', 'Acciones'

                ];
            @endphp
            
            @can('ver-cortes')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="cortes" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $cortes ) > 0 )
                            @foreach($cortes as $corte)
                                @can('ver-corte')
                                    <tr>
                                        <td>{{ $corte->nombre }}</td>
                                        <td>$ {{ $corte->total }} MXN</td>
                                        <td>{{ $corte->created_at }}</td>
                                        <td>
                                            @can('borrar-corte')
                                                <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $corte->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                                            @endcan
                                            @can('ver-corte')
                                                <a href="{{ url('/corte') }}/{{ $corte->id }}" class="btn btn-info"><i class="fas fa-list"></i> Detalles</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin cortes en caja registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('cajas.cortes.nuevo')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/corte/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/corte/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/corte/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/corte/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/corte/calcular.js') }}" type="text/javascript"></script>

@stop