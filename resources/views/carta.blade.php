@extends('home')
@section('contenido')

    @can('ver-menu')
        <div class="container-fluid col-md-12 bg-white p-2 rounded">
            <div class="container-fluid row">
                <div class="col-lg-6">
                    <x-adminlte-small-box title="Menú" icon="fas fa-list" theme="danger" url="{{ url('/pedido/menu') }}" url-text="Regresar al menú"></x-adminlte-small-box>
                </div>
                
                @if( session()->get('idPedido') )
                    
                    <div class="col-lg-6">
                        @can('ver-pedido')
                            <x-adminlte-small-box title="Mi Pedido" icon="fas fa-shopping-cart" theme="primary" url="#" url-text="Ver mi pedido" data-toggle="modal" data-target="#modalPedido"></x-adminlte-small-box>
                        @endcan
                    </div>

                @endif
            </div>
            
            <p class="text-center rounded shadow bg-info p-1"><i class="fas fa-list"></i><b> Menú de {{ $categoria->nombre }}</b></p>
            <div class="container-fluid row">
                
                @if ( count( $paquetes ) > 0 )
                    
                    @foreach ($paquetes as $paquete)
                        <div class="col-lg-4 col-md-3">
                            <x-adminlte-small-box title="$ {{ $paquete->precio }}" text="{{ $paquete->nombre }}" icon="fas fa-drumstick-bite" theme="warning" url="{{ url('/paquete/ordenar') }}/{{ $paquete->id }}" url-text="Ordenar platillo"></x-adminlte-small-box>
                        </div>
                    @endforeach

                @endif

                @foreach($platillos as $platillo)
                    
                    <div class="col-lg-4 col-md-3">
                        <x-adminlte-small-box title="${{ $platillo->precio }}" text="{{ $platillo->nombre }}" icon="fas fa-drumstick-bite" theme="warning" url="{{ url('/platillo/ordenar') }}/{{ $platillo->id }}" url-text="Ordenar platillo"></x-adminlte-small-box>
                    </div>

                @endforeach
                

            </div>
            
        </div>
    @endcan

    @include('pedido')

    @if( session()->get('idPedido') )
        <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
        <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/borrar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/sumar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/restar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/cancelar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/ordenar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/borrarPaquete.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/restarPaquete.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/sumarPaquete.js') }}" type="text/javascript"></script>
    @endif

@stop