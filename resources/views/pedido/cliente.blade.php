@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row border-bottom p-2">

            <div class="col-md-6 col-lg-6 col-sm-6">
                <h4 class="my-auto"><i class="fas fa-clipboard-list"></i> Mis Pedidos</h4>
                
            </div>

            <div class="col-md-3 col-lg-4 col-sm-6">

                <a href="{{ url('/home') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>

            </div>
            <p class="col-lg-12 p-1 bg-info text-center my-2 shadow"><i class="fas fa-info-circle"></i> <b>Instrucciones:</b> elije el pedido que deseas ver y pulsa el botón con el icono <i class="fas fa-search"></i></p>
            @php
                $heads = [

                    'Fecha de Pedido', 'Total de Pedido', 'Tipo de Pedido', 'Estatus' , 'Acciones'

                ];
            @endphp
            
            @can('ver-pedido')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="pedidos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $pedidos ) > 0 )
                            @foreach($pedidos as $pedido)
                                @can('ver-pedido')
                                    <tr>
                                        <td>{{ $pedido->created_at }}</td>
                                        <td>$ {{ $pedido->total }} M.N.</td>
                                        <td>{{ strtoupper( $pedido->tipo ) }}</td>
                                        <td>{{ $pedido->estatus }}</td>
                                        <td>
                                            @if( $pedido->estatus == 'Corte' || $pedido->estatus == 'Cobrado' || $pedido->estatus == 'Pagado' )
                                                @can('ver-pedido')
                                                    <a class="btn btn-secondary" href="{{ url('/pedido/ver') }}/{{ $pedido->id }}"><i class="fas fa-search"></i></a>
                                                @endcan
                                            @else
                                                
                                                @can('borrar-pedido')
                                                    <x-adminlte-button class="cancelar" id="cancelar" theme="danger" data-id="{{ $pedido->id }}" icon="fas fa-trash-alt" data-value="{{ $pedido->total }}"></x-adminlte-button>
                                                @endcan

                                            @endif
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin pedidos pendientes/registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    @if( auth()->user()->role(['Cliente']) )
        <script src="{{ asset('js/pedido/cliente.js') }}" type="text/javascript"></script>
    @else
        <script src="{{ asset('js/pedido/cancelar.js') }}" type="text/javascript"></script>
    @endif
    
@stop