@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-3 fw-bold text-center bg-secondary p-2 my-4 rounded shadow"><i class="fas fa-store"></i> <b>Resumen de Restaurante</b></p>
        <div class="container-fluid row">
            
            <div class="col-lg-6">
                @can('ver-pedidos')

                    @if( auth()->user()->unreadNotifications()->count() > 0 )

                        <x-adminlte-small-box title="Pedidos" text="HAY PEDIDOS PENDIENTES POR CONFIRMAR" theme="warning" url="{{url('/pedidos')}}" url-text="Ver pedidos" icon="fas fa-drumstick-bite"></x-adminlte-small-box>

                    @else

                        <x-adminlte-small-box title="Pedidos" text="Sin pedidos pendientes" theme="info" url="{{url('/pedidos')}}" url-text="Ver pedidos" icon="fas fa-drumstick-bite"></x-adminlte-small-box>
                    
                    @endif
                    
                @endcan
            </div>
            
        </div>
        
    </div>

@stop