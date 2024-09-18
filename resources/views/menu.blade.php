@extends('home')
@section('contenido')

    @can('ver-menu')
        <div class="container-fluid row bg-white p-1 rounded">

            @if( session()->get('idPedido') )
                    
                <div class="col-lg-12 col-md-12 col-sm-12">
                    @can('ver-pedido')
                        <x-adminlte-small-box title="Mi Pedido" icon="fas fa-shopping-cart" theme="primary" url="#" url-text="Ver mi pedido" data-toggle="modal" data-target="#modalPedido"></x-adminlte-small-box>
                    @endcan
                </div>

            @endif
            
            <p class="fs-6 fw-semibold text-center bg-warning my-2 rounded p-1 col-lg-10"><i class="fas fa-info-circle"></i> <u>Intrucciones:</u> elige el menú que más te guste y presiona donde dice "Ver platillos"</p>
            <div class="container-fluid row">
                
                @foreach($categorias as $categoria)

                    @php 
                        $portada = '';
                        $portada = $categoria->portada ? $categoria->portada : 'logo_min.jpg';
                    @endphp

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <x-adminlte-small-box class="shadow" title="{{ $categoria->nombre }}" icon="fas fa-drumstick-bite" theme="light" url="{{ url('/categoria/platillos') }}/{{ $categoria->id }}" url-text="Ver platillos" style="background-image: url('/img/portadas/{{ $portada }}'); background-size: contain; background-position: right; background-repeat: no-repeat;"></x-adminlte-small-box>
                    </div>

                @endforeach

            </div>
            
        </div>
    @endcan

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>

    @if( session()->get('idPedido') )
        
        @include('pedido')

        @if( auth()->user()->name === 'Invitado' )
            
            @include('cliente')

            <script src="{{ asset('js/pedido/pedir.js') }}" type="text/javascript"></script>
        
        @else

            <script src="{{ asset('js/pedido/ordenar.js') }}" type="text/javascript"></script>

        @endif
    
    @endif

    @if( session()->get('idPedido') )
        
        <script src="{{ asset('js/pedido/borrar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/sumar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/restar.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/cancelar.js') }}" type="text/javascript"></script>
        
        <script src="{{ asset('js/pedido/borrarPaquete.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/restarPaquete.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/pedido/sumarPaquete.js') }}" type="text/javascript"></script>
    
    @endif

@stop