@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 bg-white p-2 rounded">
        
        <p class="fs-3 fw-bold text-center bg-secondary p-2 my-4 rounded shadow"><i class="fas fa-store"></i> <b>Inicio de Restaurante</b></p>
        <div class="container-fluid row">
            
            <div class="col-lg-4 col-md-6 col-sm-12">
                @can('ver-pedidos')

                    @if( auth()->user()->unreadNotifications()->count() > 0 )

                        <x-adminlte-small-box title="Pedidos" text="HAY PEDIDOS PENDIENTES" theme="warning" url="{{url('/pedidos')}}" url-text="Ver pedidos" icon="fas fa-shopping-cart"></x-adminlte-small-box>

                    @else

                        <x-adminlte-small-box title="Pedidos" text="Sin pedidos pendientes" theme="info" url="{{url('/pedidos')}}" url-text="Ver pedidos" icon="fas fa-drumstick-bite"></x-adminlte-small-box>
                    
                    @endif
                    
                @endcan
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <x-adminlte-small-box title="WingsVideos" text="Mira como ordenar tu comida favorita" theme="purple" url-text="Ver videos" url="#" icon="fab fa-youtube" data-toggle="modal" data-target="#modalVideos"></x-adminlte-small-box>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <x-adminlte-small-box title="Menú de Restaurante" text="Todos los platillos del restaurante" theme="info" url-text="Ver menú" icon="fas fa-clipboard-list" data-toggle="modal" data-target="#modalPreeliminar"></x-adminlte-small-box>
            </div>
        </div>
        
    </div>

    @include('preeliminar')
    @include('videos')

@stop