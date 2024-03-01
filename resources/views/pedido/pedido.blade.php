@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="container-fluid row">
                <h4 class="col-md-12 my-auto"><i class="fas fa-shopping-cart"></i> Pedido</h4>
                <p class="col-md-2 fs-5 fw-semibold bg-secondary p-2 m-1 rounded">Tipo de Pedido: {{ $pedido->tipo }}</p>
                <p class="col-md-3 fs-5 fw-semibold bg-secondary p-2 m-1 rounded">Fecha de Pedido: {{ $pedido->created_at }}</p>
                <p class="col-md-3 fs-5 fw-semibold p-2 m-1 bg-success rounded">Total: $ {{ $pedido->total }} MXN</p>
                
                <div class="col-md-3 m-1">
                    @can('confirmar-pedido')
                        @if( $pedido->estatus == 'Pendiente' )
                            <x-adminlte-button id="confirmar" class="float-end" label="Confirmar" icon="fas fa-check" theme="primary"></x-adminlte-button>
                        @endif
                    @endcan
                    <a href="{{ url('/pedidos') }}" class="btn btn-success mx-1 rounded">
                        <i class="fas fa-shopping-cart"></i> Pedidos
                    </a>
                </div>
                <input type="hidden" name="idPedido" id="idPedido" value="{{ $pedido->id }}">
            </div>

            @php
                $heads = [

                    'Cantidad', 'Platillo', 'Salsa(s)/Preparación', 'Monto'

                ];
            @endphp
            
            @can('ver-pedido')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="pedidos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $platillos ) > 0 )
                            @foreach($platillos as $platillo)
                                <tr>
                                    <td>{{ $platillo->cantidad }}</td>
                                    <td>{{ $platillo->nombre }}</td>
                                    <td>{{ $platillo->preparacion }}</td>
                                    <td>$ {{ ($platillo->precio * $platillo->cantidad) }} MXN</td>
                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin platillos en el pedido</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/confirmar.js') }}" type="text/javascript"></script>
    
@stop