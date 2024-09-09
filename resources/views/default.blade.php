@extends('home')
@section('contenido')

    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-2 fw-bold text-center bg-info p-2 my-4 rounded shadow"><i class="fas fa-smile"></i> Resumen de Cliente</p>
        <div class="container-fluid row">
            
            <div class="col-lg-4 col-md-6 col-sm-12">
                @if( auth()->user()->hasRole(['Cliente']) && auth()->user()->telefonos->count() > 0 && auth()->user()->domicilios->count() > 0 )
                    
                    <x-adminlte-small-box title="Ordenar" text="Crear nuevo pedido" theme="warning" url="#" id="pedido" icon="fas fa-shopping-cart" url-text="Ordenar aquí"></x-adminlte-small-box>

                @else

                    <div class="col-lg-12 my-2 bg-danger p-2 text-center">
                        <p class="fs-3 fw-semibold text-center"><i class="fa fa-info"></i> Es necesario registrar un telefono y un domicilio para ordenar. <i class="fas fa-info"></i></p>
                        <a href="{{ url('profile/username') }}" class="text-center btn btn-danger border"><i class="fas fa-mouse-pointer"></i> <b>Registrar Aquí</b></a>
                    </div>
                
                @endif
                
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <x-adminlte-small-box title="Menú de Restaurante" text="Todos los platillos del restaurante" theme="info" url-text="Ver menú" icon="fas fa-clipboard-list" url="{{ url('/menu/descargar') }}" ></x-adminlte-small-box>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <x-adminlte-small-box title="Mi Perfil" text="Datos de cliente" theme="primary" url-text="Ver mi perfil" icon="fas fa-user-circle" url="/profile/username"></x-adminlte-small-box>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                @can('ver-pedido')
                    <x-adminlte-small-box title="Mis Pedidos" text="Historial de pedidos" theme="success" url="{{ url('/pedidos/cliente') }}" url-text="Ver pedidos" icon="fas fa-list-alt"></x-adminlte-small-box>
                @endcan
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <x-adminlte-small-box title="WingsVideos" text="Mira como ordenar tu comida favorita" theme="purple" url-text="Ver videos" icon="fab fa-youtube" url="#" data-toggle="modal" data-target="#modalVideos"></x-adminlte-small-box>
            </div>

            @can('ver-notificaciones')
                <div class="col-lg-12">
                    <p class="fs-3 fw-semibold bg-info p-2 m-2"><i class="fas fa-bell"></i> Notificaciones de tus pedidos</p>
                    @php
                        $heads = [

                            'Pedido', 'Total', 'Estatus', 'Leído'

                        ];
                    @endphp
                    
                    <div class="container-fluid col-lg-12 my-3">
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
                                                <x-adminlte-button class="notification" id="notification" title="Ok, enterado" theme="primary" data-id="{{ $notification->id }}" icon="fas fa-check-double"></x-adminlte-button>
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

        @include('preeliminar')
        @include('videos')
        
    </div>
    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/pedido.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/notification.js') }}" type="text/javascript"></script>

@stop