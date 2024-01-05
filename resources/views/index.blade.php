@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-2 fw-bold text-center bg-warning p-2 my-4 rounded shadow">Resumen de Restaurante</p>
        <div class="container-fluid row">
            
            <div class="col-lg-3">
                <x-adminlte-small-box title="Ventas" text="Mis ventas" theme="secondary" url="" url-text="Ver datos"></x-adminlte-small-box>
            </div>
            <div class="col-lg-3">
                <x-adminlte-small-box title="Pedidos" text="Pedidos totales" theme="success" url="{{url('/pedidos')}}" url-text="Ver datos"></x-adminlte-small-box>
            </div>
            <div class="col-lg-3">
                <x-adminlte-small-box title="Clientes" text="Clientes registrados" theme="warning" url="" url-text="Ver datos"></x-adminlte-small-box>
            </div>

        </div>
        
    </div>

@stop