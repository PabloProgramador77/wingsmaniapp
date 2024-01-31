@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-shopping-cart"></i> Mis Pedidos</h4>
            </div>

            @php
                $heads = [

                    'Fecha de Pedido', 'Total de Pedido', 'Tipo de Pedido', 'Estatus' , 'Acciones'

                ];
            @endphp
            
            <div class="container-fluid col-md-12 my-3">
                <x-adminlte-datatable id="pedidos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                    
                    @if( count( $pedidos ) > 0 )
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>{{ $pedido->created_at }}</td>
                                <td>
                                    <a href="{{ url('/pedido/ver') }}/{{ $pedido->id }}">
                                        $ {{ $pedido->total }} M.N.
                                    </a>
                                </td>
                                <td>{{ $pedido->tipo }}</td>
                                <td>{{ $pedido->estatus }}</td>
                                <td>
                                    @if( $pedido->estatus != 'Pagado' && $pedido->estatus != 'Cobrado' )
                                        <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $pedido->id }}" icon="fas fa-pen"></x-adminlte-button>
                                        <x-adminlte-button class="cancelar" id="cancelar" label="Cancelar" theme="danger" data-id="{{ $pedido->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                                    @else
                                        <a class="btn btn-secondary" href="{{ url('/pedido/ver') }}/{{ $pedido->id }}"><i class="fas fa-search"></i> Ver</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="4" class="text-info">Sin pedidos pendientes/registrados</td>
                        </tr>
                    @endif
                    
                </x-adminlte-datatable>
            </div>

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/cancelar.js') }}" type="text/javascript"></script>
    
@stop