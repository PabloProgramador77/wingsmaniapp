@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-2 fw-bold text-center bg-secondary p-2 my-4 rounded shadow">Resumen de Restaurante</p>
        <div class="container-fluid row">
            
            <div class="col-lg-6">
                <x-adminlte-small-box title="Pedidos" text="Hay {{ auth()->user()->unreadNotifications()->count() }} pedidos pendientes" theme="warning" url="{{url('/pedidos')}}" url-text="Ver pedidos" icon="fas fa-drumstick-bite"></x-adminlte-small-box>
            </div>
            
        </div>
        
    </div>

@stop