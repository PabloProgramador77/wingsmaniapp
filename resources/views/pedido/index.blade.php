@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-shopping-cart"></i> Pedidos</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/home') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>
            <p class="p-1 bg-info fw-semibold text-center my-2 col-lg-12"><i class="fas fa-info-circle"></i> En amarillo se marcan los pedidos nuevos que deben ser confirmados para su preparación en cocina. Para confirmarlos pulsa el botón con el icono <i class="fas fa-check"></i></p>

            @php
                $heads = [

                    'Cliente', 'Total de Pedido', 'Tipo de Pedido', 'Fecha', 'Acciones'

                ];
            @endphp
            
            @can('ver-pedidos')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="pedidos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $pedidos ) > 0 )
                            @foreach($pedidos as $pedido)
                                @can('ver-pedido')
                                    <tr @if( $pedido->estatus == 'Pendiente' ) class="bg-warning" @endif>
                                        <td>
                                            @can('ver-pedido')
                                                <a href="{{ url('/pedido/ver') }}/{{ $pedido->id }}">
                                                    {{ $pedido->cliente->name }}
                                                </a>
                                            @endcan
                                        </td>
                                        <td>$ {{ $pedido->total }} M.N.</td>
                                        <td>{{ $pedido->tipo }}</td>
                                        <td>{{ $pedido->created_at }}</td>
                                        <td>
                                            @if( $pedido->estatus == 'Cobrado' )
                                                @can('cobrar-pedido')
                                                    <x-adminlte-button class="pagar" id="pagar" title="Cerrar" theme="warning" data-id="{{ $pedido->id }}" icon="fas fa-lock"></x-adminlte-button>
                                                @endcan
                                            @endif

                                            @if( $pedido->estatus == 'Pendiente' )
                                                @can('borrar-pedido')
                                                    <x-adminlte-button class="cancelar" id="cancelar" title="Cancelar" theme="danger" data-id="{{ $pedido->id }}" icon="fas fa-trash-alt" data-value="{{ $pedido->cliente->name }}"></x-adminlte-button>
                                                @endcan
                                                @can('ver-pedido')
                                                    <a class="btn btn-primary" href="{{ url('/pedido/ver') }}/{{ $pedido->id }}"><i class="fas fa-check"></i></a>
                                                @endcan
                                            @endif
                                            
                                            @if( $pedido->estatus == 'Abierto' )
                                                @can('borrar-pedido')
                                                    <x-adminlte-button class="cancelar" id="cancelar" title="Cancelar" theme="danger" data-id="{{ $pedido->id }}" icon="fas fa-trash-alt" data-value="{{ $pedido->cliente->name }}"></x-adminlte-button>
                                                @endcan
                                                @can('cobrar-pedido')
                                                    @if( $pedido->tipo == 'delivery' )
                                                        <x-adminlte-button class="envios" id="cobrar" title="Cobrar" theme="success" data-id="{{ $pedido->id }}" icon="fas fa-money-bill-alt" data-toggle="modal" data-target="#modalEnvios" data-id="{{ $pedido->id }}" data-value="{{ $pedido->cliente->name }}"></x-adminlte-button>
                                                    @else
                                                        <x-adminlte-button class="cobrar" id="cobrar" title="Cobrar" theme="success" data-id="{{ $pedido->id }}" icon="fas fa-money-bill-alt"></x-adminlte-button>
                                                    @endif
                                                    
                                                @endcan
                                            @endif
                                            
                                            @if( $pedido->estatus == 'Pagado' )
                                                <p class="fs-4 fw-semibold text-center bg-success p-1 m-1"><strong>Pedido Cerrado</strong></p>
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

    @include('pedido.envios')
    
    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/cancelar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/cobrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/pagar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/envio.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/agregarEnvio.js') }}" type="text/javascript"></script>
    
@stop