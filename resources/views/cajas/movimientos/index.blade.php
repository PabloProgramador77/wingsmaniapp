@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-money-bill"></i> Movimientos de {{ $caja->nombre }}</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
                <input type="hidden" name="idCaja" id="idCaja" value="{{ $caja->id }}">
            </div>
            <div class="col-md-3">
                @can('agregar-movimiento')
                    <x-adminlte-button label="Nuevo Mov." theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/cajas') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-cash-register"></i> Cajas
                </a>
                <a href="{{ url('/home') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-home"></i>
                </a>
            </div>

            @php
                $heads = [

                    'Movimiento', 'Monto', 'Fecha', 'Acciones'

                ];
            @endphp
            
            @can('ver-movimientos')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="movimientos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $movimientos ) > 0 )
                            @foreach($movimientos as $movimiento)
                                @can('ver-movimiento')
                                    <tr>
                                        <td>{{ $movimiento->tipo }} - {{ $movimiento->concepto }}</td>
                                        <td>$ {{ $movimiento->monto }} MXN</td>
                                        <td>{{ $movimiento->created_at }}</td>
                                        <td>
                                            @if( $movimiento->tipo !== 'Corte' )
                                                @can('editar-movimiento')
                                                    <x-adminlte-button class="editar" id="editar"  theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $movimiento->id }}" icon="fas fa-edit"></x-adminlte-button>
                                                @endcan
                                                @can('borrar-movimiento')
                                                    <x-adminlte-button class="eliminar" id="eliminar"  theme="danger" data-id="{{ $movimiento->id }}" icon="fas fa-trash-alt" data-value="{{ $movimiento->concepto }}"></x-adminlte-button>
                                                @endcan
                                            @else
                                                Los cortes de caja no se permiten editarlos o borrarlos.
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin movimientos en caja registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('cajas.movimientos.nuevo')
    @include('cajas.movimientos.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/movimiento/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/movimiento/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/movimiento/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/movimiento/borrar.js') }}" type="text/javascript"></script>

@stop