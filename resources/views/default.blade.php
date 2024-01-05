@extends('home')
@section('contenido')

    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-2 fw-bold text-center bg-info p-2 my-4 rounded shadow">Resumen de Cliente</p>
        <div class="container-fluid row">
            
            <div class="col-lg-12 my-2">
                <x-adminlte-button label="Ordenar Ahora" theme="warning" icon="fas fa-utensils" id="pedido"></x-adminlte-button>
            </div>
            <div class="col-lg-4">
                <x-adminlte-small-box title="Platillos Favoritos" text="Mis platillos favoritos" theme="secondary" url="" url-text="Ver datos"></x-adminlte-small-box>
            </div>
            <div class="col-lg-4">
                <x-adminlte-small-box title="Mis Pedidos" text="Historial de pedidos" theme="success" url="{{ url('/pedidos/cliente') }}" url-text="Ver datos"></x-adminlte-small-box>
            </div>
            <div class="col-lg-4">
                <x-adminlte-small-box title="Promociones" text="Promociones" theme="info" url="" url-text="Ver datos"></x-adminlte-small-box>
            </div>

        </div>
        
    </div>
    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/pedido.js') }}" type="text/javascript"></script>

@stop