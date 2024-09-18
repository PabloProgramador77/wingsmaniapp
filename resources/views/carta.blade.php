@extends('home')
@section('contenido')

    @can('ver-menu')
        <div class="container-fluid row bg-white p-2 rounded">
            <div class="container-fluid row">
                <p class="p-1 bg-warning text-center col-lg-12 col-md-12 col-sm-12 fs-6 fw-semibold"><i class="fas fa-info-circle"></i> <u>Intrucciones</u>: Elije el platillo que más te guste y pulsa en donde dice "Ordenar"<i class="fas fa-info-circle"></i></p>
                <div class="col-lg-6">
                    <x-adminlte-small-box title="Menú" icon="fas fa-backward" theme="danger" url="{{ url('/pedido/menu') }}" url-text="Regresar al menú"></x-adminlte-small-box>
                </div>
                
                @if( session()->get('idPedido') )
                    
                    <div class="col-lg-6">
                        @can('ver-pedido')
                            <x-adminlte-small-box title="Mi Pedido" icon="fas fa-shopping-cart" theme="primary" url="#" url-text="Ver mi pedido" data-toggle="modal" data-target="#modalPedido"></x-adminlte-small-box>
                        @endcan
                    </div>

                @endif
            </div>
            
            <p class="text-center d-block col-lg-12 rounded shadow bg-secondary p-1"><b> Menú de {{ $categoria->nombre }}</b></p>
            <div class="container-fluid row">
                
                @if ( count( $paquetes ) > 0 )

                    @foreach ($paquetes as $paquete)

                        @if( count( $paquete->platillos ) > 0 )
                        
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <x-adminlte-small-box class="prepararPaquete shadow" title="{{ $paquete->nombre }}" text="$ {{ $paquete->precio }}" icon="fas fa-drumstick-bite" theme="light" url="#" url-text="Ordenar" data-id="{{ $paquete->id }}" data-value="{{ $paquete->nombre }}, {{ $paquete->cantidadBebidas }}, {{ $paquete->cantidadSalsas }}, {{ $paquete->platillosEditables }}" data-toggle="modal" data-target="#modalPlatillosPaquete" style="background-image: url('/img/alitas02.jpg'); background-size: contain; background-position: right; background-repeat: no-repeat;"></x-adminlte-small-box>
                            </div>

                        @else

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <x-adminlte-small-box class="shadow" title="{{ $paquete->nombre }}" text="$ {{ $paquete->precio }}" icon="fas fa-drumstick-bite" theme="light" url="{{ url('/paquete/ordenar') }}/{{ $paquete->id }}" url-text="Ordenar" style="background-image: url('/img/alitas02.jpg'); background-size: contain; background-position: right; background-repeat: no-repeat;"></x-adminlte-small-box>
                            </div>

                        @endif

                            
                    
                    @endforeach

                @endif

                @foreach($platillos as $platillo)

                    @php
                        $portada = $platillo->portada ?: 'logo_min.jpg';
                    @endphp

                    @if( count( $platillo->salsas ) > 0 || count( $platillo->preparaciones ) > 0 )
                    
                        <div class="col-lg-4 col-md-6 col-sm-12 overflow-auto">
                            <x-adminlte-small-box title="{{ $platillo->nombre }}" text="$ {{ $platillo->precio }}" icon="fas fa-drumstick-bite" theme="light" url-text="Ordenar" url="#" data-id="{{ $platillo->id }}" data-value="{{ $platillo->nombre }}, {{ $platillo->cantidadSalsas }}" data-toggle="modal" data-target="#modalSalsas" class="prepararPlatillo shadow" style="background-image: url('/img/portadas/{{ $portada }}'); background-size: contain; background-position: right; background-repeat: no-repeat;"></x-adminlte-small-box>
                        </div>

                    @else

                        <div class="col-lg-4 col-md-6 col-sm-12 overflow-auto">
                            <x-adminlte-small-box class="shadow text-dark" title="{{ $platillo->nombre }}" text="$ {{ $platillo->precio }}" icon="fas fa-drumstick-bite" theme="light" url-text="Ordenar" url="{{ url('/platillo/ordenar') }}/{{ $platillo->id }}" style="background-image: url('/img/portadas/{{ $portada }}'); background-size: contain; background-position: right; background-repeat: no-repeat;"></x-adminlte-small-box>
                        </div>
                        
                    @endif

                @endforeach
                

            </div>
            
        </div>
    @endcan

    @include('pedido')
    @include('salsas')
    @include('preparaciones')
    @include('indexPaquete')
    @include('salsasPaquete')
    @include('preparacionesPaquete')
    @include('bebidasPaquete')
    
    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>

    @if( session()->get('idPedido') )

        @if( auth()->user()->name === 'Invitado' )
            
            @include('cliente')

            <script src="{{ asset('js/pedido/pedir.js') }}" type="text/javascript"></script>

        @else

            <script src="{{ asset('js/pedido/ordenar.js') }}" type="text/javascript"></script>
            
        @endif
        
        <script src="{{ asset('js/pedido/borrar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/sumar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/restar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/cancelar.js') }}" type="text/javascript"></script>
        
        <script src="{{ asset('js/pedido/borrarPaquete.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/restarPaquete.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/sumarPaquete.js') }}" type="text/javascript"></script>
    
    @endif

    <script src="{{ asset('js/pedido/buscarSalsas.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/buscarPreparacionesPaquete.js') }}" type="text/javascript"></script>

@stop