@extends('home')
@section('contenido')

    @can('ver-menu')
        <div class="container-fluid col-md-12 bg-white p-1 rounded">
            
            <p class="fs-2 fw-bold text-center bg-info p-1 my-4 rounded shadow"><i class="fas fa-info-circle"></i> Intrucciones: Elige el menú que más te guste y pulsa donde dice "Ver platillos" <i class="fas fa-info-circle"></i></p>
            <div class="container-fluid row">
                
                @foreach($categorias as $categoria)
                    
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <x-adminlte-small-box title="{{ $categoria->nombre }}" icon="fas fa-drumstick-bite" theme="warning" url="{{ url('/categoria/platillos') }}/{{ $categoria->id }}" url-text="Ver platillos"></x-adminlte-small-box>
                    </div>

                @endforeach

            </div>
            
        </div>
    @endcan

@stop