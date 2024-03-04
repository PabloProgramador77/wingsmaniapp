@extends('home')
@section('contenido')

    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-2 fw-bold text-center bg-info p-2 my-4 rounded shadow"><i class="fas fa-smile"></i> Resumen de Cliente</p>
        <div class="container-fluid row">
            
            <div class="col-lg-12 my-2">
                <x-adminlte-button label="Ordenar Ahora" theme="warning" icon="fas fa-utensils" id="pedido"></x-adminlte-button>
            </div>
            <div class="col-lg-6">
                @can('ver-pedidos')
                    <x-adminlte-small-box title="Mis Pedidos" text="Historial de pedidos" theme="success" url="{{ url('/pedidos/cliente') }}" url-text="Ver pedidos"></x-adminlte-small-box>
                @endcan
            </div>

            @can('ver-notificaciones')
                <div class="col-lg-12">
                    <p class="fs-3 fw-semibold bg-info p-2 m-2"><i class="fas fa-bell"></i> Notificaciones de Pedidos</p>
                    @php
                        $heads = [

                            'Pedido', 'Total', 'Estatus', 'Leído'

                        ];
                    @endphp
                    
                    <div class="container-fluid col-md-12 my-3">
                        <x-adminlte-datatable id="pedidos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                            
                        @if( auth()->user()->unreadNotifications()->count() > 0 )
                        
                            @foreach( auth()->user()->unreadNotifications as $notification)
                                @can('ver-notificacion')
                                    <tr>
                                        <td>{{ strtoupper( $notification->data['tipo'] ) }} </td>
                                        <td>$ {{ $notification->data['total'] }} M.N.</td>
                                        <td><strong>{{ $notification->data['mensaje'] }}</strong></td>
                                        <td>
                                            @can('confirmar-notificacion')
                                                <x-adminlte-button class="notification" id="notification" label="Ok, enterado" theme="primary" data-id="{{ $notification->id }}"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else

                            <tr><td colspan="4">Sin notificaciones</td></tr>

                        @endif

                        </x-adminlte-datatable>
                    </div>

                </div>
            @endcan

        </div>
        
    </div>
    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/pedido.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/notification.js') }}" type="text/javascript"></script>

@stop