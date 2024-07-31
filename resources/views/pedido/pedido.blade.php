@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="container-fluid row">
                <h4 class="col-md-12 my-auto"><i class="fas fa-shopping-cart"></i> Pedido</h4>
                @if ( $pedido->tipo == 'delivery' && $pedido->estatus == 'Pendiente' )
                    <p class="col-md-12 m-1 p-1 bg-info fw-semibold text-center"><i class="fas fa-info-circle"></i> Para los pedidos a domicilio, se hace un cargo extra al final de su preparación en el restaurante. Por lo que el total mostrado no es el precio final, se descargará la comanda para cocina y puedes regresar al listado principal pulsando el botón "Pedidos"</p>    
                @endif
                
                <p class="col-lg-3 col-md-2 fs-5 fw-semibold bg-secondary p-2 m-1 rounded">Tipo de Pedido: <b>{{ strtoupper( $pedido->tipo ) }}</b></p>
                <p class="col-lg-3 col-md-3 fs-5 fw-semibold bg-secondary p-2 m-1 rounded">Fecha: <b>{{ $pedido->created_at }}</b></p>
                
                <div class="col-lg-4 col-md-6 m-1">
                    
                    @can('confirmar-pedido')
                        @if( $pedido->estatus == 'Pendiente' )
                            <a href="{{ url('/pedido/confirmar') }}/{{ $pedido->id }}" class="btn btn-primary mx-2 confirmar" title="Confirmar Pedido"><i class="fas fa-check-double"></i> Confirmar</a>
                        @endif
                    @endcan

                    @if( $pedido->estatus !== 'Cobrado' )
                        <x-adminlte-button theme="secondary" label="Editar" id="editarPedido" icon="fas fa-edit" data-id="{{ $pedido->id }}" data-value="{{ $pedido->cliente->name }}" class="mx-2"></x-adminlte-button>
                    @endif

                    @if( auth()->user()->hasRole(['Cliente']) )

                        <a href="{{ url('/pedidos/cliente') }}" class="btn btn-warning rounded">
                            <i class="fas fa-clipboard-list"></i> Mis Pedidos
                        </a>

                    @else
                        
                        <a href="{{ url('/pedidos') }}" class="btn btn-warning rounded">
                            <i class="fas fa-shopping-cart"></i> Pedidos
                        </a>

                    @endif
                    
                </div>
                <input type="hidden" name="idPedido" id="idPedido" value="{{ $pedido->id }}">
            </div>
            <div class="container-fluid row">
                <p class="col-lg-3 col-md-4 col-sm-6 fw-semibold bg-light p-2 m-1 rounded"><b>Cliente:</b> {{ $pedido->cliente->name }}</p>

                @foreach( $pedido->cliente->telefonos as $telefono)
                    <p class="col-lg-4 col-md-4 col-sm-6 fw-semibold bg-light p-2 m-1 rounder"><b>Telefono(s):</b> {{ $telefono->nunmero }} </p>
                @endforeach
                
                @if( $pedido->tipo == 'delivery' )
                    <p class="col-lg-4 col-md-4 col-sm-6 fw-semibold bg-light p-2 m-1 rounded"><b>Dirección:</b> {{ $pedido->domicilio->direccion }}</p>
                @endif
                
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
                                    <td>$ {{ ($platillo->precio * $platillo->cantidad) }}</td>
                                </tr>
                            @endforeach

                        @endif

                        @if ( count( $paquetes ) > 0 )

                            @foreach ($paquetes as $paquete)
                                <tr>
                                    <td>{{ $paquete->cantidad }}</td>
                                    <td>{{ $paquete->nombre }}</td>
                                    <td>{{ $paquete->preparacion }}</td>
                                    <td>$ {{ $paquete->precio * $paquete->cantidad }}</td>
                                </tr>
                            @endforeach
                            
                        @endif
                        <tr class="bg-success p-1">
                            <td colspan="3">Total: </td>
                            <td>$ {{ $pedido->total }}</td>
                        </tr>
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/editar.js') }}" type="text/javascript"></script>
    
@stop