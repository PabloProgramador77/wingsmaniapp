@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-2 fw-bold text-center bg-warning p-2 my-4 rounded shadow">Resumen de Cliente</p>
        <div class="container-fluid row">
            
            <div class="col-lg-3">
                <x-adminlte-small-box title="Platillos Favoritos" text="Mis platillos favoritos" theme="secondary" url="" url-text="Ver datos"></x-adminlte-small-box>
            </div>
            <div class="col-lg-3">
                <x-adminlte-small-box title="Mis Pedidos" text="Historial de pedidos" theme="success" url="" url-text="Ver datos"></x-adminlte-small-box>
            </div>
            <div class="col-lg-3">
                <x-adminlte-small-box title="Promociones" text="Promociones" theme="warning" url="" url-text="Ver datos"></x-adminlte-small-box>
            </div>

        </div>
        
    </div>

@stop