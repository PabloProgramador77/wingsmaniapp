@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-cash-register"></i> Cajas</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-caja')
                    <x-adminlte-button label="Agregar caja" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/home') }}" class="btn btn-success mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Caja', 'Total', 'Estatus', 'Acciones'

                ];
            @endphp
            
            @can('ver-cajas')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="cajas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $cajas ) > 0 )
                            @foreach($cajas as $caja)
                                @can('ver-caja')
                                    <tr>
                                        <td>{{ $caja->nombre }}</td>
                                        <td>$ {{ $caja->total }} MXN</td>
                                        <td>{{ $caja->estatus }}</td>
                                        <td>
                                            @if ( $caja->estatus == 'Disponible' )

                                                @can('editar-caja')
                                                    <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $caja->id }}" icon="fas fa-pen"></x-adminlte-button>
                                                @endcan
                                                @can('borrar-caja')
                                                    <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $caja->id }}" icon="fas fa-trash-alt" data-value="{{ $caja->nombre }}"></x-adminlte-button>
                                                @endcan
                                                @can('abrir-caja')
                                                    <x-adminlte-button class="abrir" label="Abrir" theme="primary" data-toggle="modal" data-target="#modalAbrir" data-id="{{ $caja->id }}" icon="fas fa-lock-open"></x-adminlte-button>
                                                @endcan
                                                @can('ver-movimientos')
                                                    <a href="{{ url('/movimientos') }}/{{ $caja->id }}" class="btn btn-secondary"><i class="fas fa-money-bill"></i> Movimientos</a>
                                                @endcan

                                            @else

                                                @can('cerrar-caja')
                                                    <x-adminlte-button class="cerrar" label="Cerrar" theme="warning" data-toggle="modal" data-target="#modalCerrar" data-id="{{ $caja->id }}" icon="fas fa-lock"></x-adminlte-button>
                                                @endcan
                                                
                                            @endif
                                            @can('ver-cortes')
                                                <a href="{{ url('/cortes') }}/{{ $caja->id }}" class="btn btn-success"><i class="fas fa-cash-register"></i> Cortes</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin cajas de menú registradas</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('cajas.nuevo')
    @include('cajas.editar')

    @if ($caja->estatus == 'Disponible')
        @include('cajas.abrir')    
    @else
        @include('cajas.cerrar')
    @endif
    

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/caja/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/caja/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/caja/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/caja/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/caja/abrir.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/caja/cerrar.js') }}" type="text/javascript"></script>

@stop