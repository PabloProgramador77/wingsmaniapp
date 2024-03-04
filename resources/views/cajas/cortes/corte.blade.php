@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="container-fluid row">
                <h4 class="col-md-12 my-auto"><i class="fas fa-cash-register"></i> Corte de Caja - {{ $corte->caja->nombre }}</h4>
                <p class="col-md-3 fs-5 fw-semibold bg-secondary p-2 m-1 rounded">Fecha de Corte: {{ $corte->created_at }}</p>
                <p class="col-md-3 fs-5 fw-semibold p-2 m-1 bg-success rounded">Total: $ {{ $corte->total }} MXN</p>
                
                <div class="col-md-3 m-1">
                    <x-adminlte-button id="imprimir" class="float-end" label="Imprimir" icon="fas fa-print" theme="primary"></x-adminlte-button>
                    <a href="{{ url('/cortes') }}/{{ $corte->idCaja }}" class="btn btn-secondary mx-2"><i class="fas fa-cash-register"></i> Cortes</a>
                </div>
                <input type="hidden" name="idCorte" id="idCorte" value="{{ $corte->id }}">
            </div>

            @php
                $heads = [

                    'Cliente', 'Total', 'Tipo de Pedido', 'Platillos'

                ];
            @endphp
            
            @can('ver-pedido')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="pedidos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $pedidos ) > 0 )
                            @foreach($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->cliente->name }}</td>
                                    <td>$ {{ $pedido->total }} MXN</td>
                                    <td>{{ $pedido->tipo }}</td>
                                    <td>
                                        <ul class="list-unstyled">

                                            @foreach( $pedido->platillos as $platillo)
                                                <li class="text-center">{{ $platillo->nombre }}</li>
                                            @endforeach

                                        </ul>
                                    </td>
                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin pedidos asignado en el corte</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    
@stop