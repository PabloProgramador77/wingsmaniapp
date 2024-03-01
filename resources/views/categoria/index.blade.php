@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-tags"></i> Categorías de Menú</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                @can('agregar-categoria')
                    <x-adminlte-button label="Agregar categoria" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                @endcan
                <a href="{{ url('/home') }}" class="btn btn-success mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Categoría de Menú', 'Acciones'

                ];
            @endphp
            
            @can('ver-categorias')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="categorias" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $categorias ) > 0 )
                            @foreach($categorias as $categoria)
                                @can('ver-categoria')
                                    <tr>
                                        <td>{{ $categoria->nombre }}</td>
                                        <td>
                                            @can('editar-categoria')
                                                <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $categoria->id }}" icon="fas fa-pen"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-categoria')
                                                <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $categoria->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin categorias de menú registradas</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    @include('categoria.nuevo')
    @include('categoria.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/categoria/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/categoria/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/categoria/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/categoria/borrar.js') }}" type="text/javascript"></script>

@stop