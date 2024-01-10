@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-shopping-cart"></i> Pedidos</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>

            @php
                $heads = [

                    'Cliente', 'Total de Pedido', 'Tipo de Pedido', 'Fecha', 'Acciones'

                ];
            @endphp
            
            <div class="container-fluid col-md-12 my-3">
                <x-adminlte-datatable id="pedidos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                    
                    @if( count( $pedidos ) > 0 )
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td>
                                    <a href="{{ url('/pedido/ver') }}/{{ $pedido->id }}">
                                        {{ $pedido->cliente->name }}
                                    </a>
                                </td>
                                <td>$ {{ $pedido->total }} M.N.</td>
                                <td>{{ $pedido->tipo }}</td>
                                <td>{{ $pedido->created_at }}</td>
                                <td>
                                    <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $pedido->id }}" icon="fas fa-pen"></x-adminlte-button>
                                    <x-adminlte-button class="cancelar" id="cancelar" label="Borrar" theme="danger" data-id="{{ $pedido->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
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