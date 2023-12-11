@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-drumstick-bite"></i> Platillos</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                <x-adminlte-button label="Agregar platillo" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
            </div>

            @php
                $heads = [

                    'Platillo', 'Precio', 'Acciones'

                ];
            @endphp
            
            <div class="container-fluid col-md-12 my-3">
                <x-adminlte-datatable id="platillos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                    
                    @if( count( $platillos ) > 0 )
                        @foreach($platillos as $platillo)
                            <tr>
                                <td>{{ $platillo->nombre }}</td>
                                <td>$ {{ $platillo->precio }} M.N.</td>
                                <td>
                                    <x-adminlte-button class="editar" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $platillo->id }}" icon="fas fa-pen"></x-adminlte-button>
                                    <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $platillo->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="4" class="text-info">Sin platillos registrados</td>
                        </tr>
                    @endif
                    
                </x-adminlte-datatable>
            </div>

        </div>

    </div>

    @include('platillo.nuevo')
    @include('platillo.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/platillo/borrar.js') }}" type="text/javascript"></script>

@stop