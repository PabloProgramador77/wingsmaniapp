@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="container-fluid row">
                <h4 class="col-md-12 my-auto"><i class="fas fa-shopping-cart"></i> Mi Pedido</h4>
                <p class="col-md-3 fs-5 fw-semibold bg-info p-2 m-1 rounded">Tipo de Pedido: {{ $pedido->tipo }}</p>
                <p class="col-md-4 fs-5 fw-semibold bg-secondary p-2 m-1 rounded">Fecha de Pedido: {{ $pedido->created_at }}</p>
                <p class="col-md-4 fs-5 fw-semibold p-2 m-1 bg-success rounded">Total: $ {{ $pedido->total }} MXN</p>
            </div>

            @php
                $heads = [

                    'Cantidad', 'Platillo', 'Salsa(s)/Preparación', 'Monto'

                ];
            @endphp
            
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

        </div>

    </div>
    
@stop