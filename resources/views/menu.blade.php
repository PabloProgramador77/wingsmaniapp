@extends('home')
@section('contenido')

    @can('ver-menu')
        <div class="container-fluid col-md-12 bg-white p-2 rounded">
            
            <p class="fs-2 fw-bold text-center bg-secondary p-2 my-4 rounded shadow">Elige la categoría que más te guste</p>
            <div class="container-fluid row">
                
                @foreach($categorias as $categoria)
                    
                    <div class="col-lg-4">
                        <x-adminlte-small-box title="{{ $categoria->nombre }}" icon="fas fa-tag" theme="warning" url="{{ url('/categoria/platillos') }}/{{ $categoria->id }}" url-text="Ver platillos"></x-adminlte-small-box>
                    </div>

                @endforeach

            </div>
            
        </div>
    @endcan

@stop