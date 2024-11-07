@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-lemon"></i> Aderezos de Platillos</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>
            <div class="col-md-3">
                <x-adminlte-button label=" Aderezo" theme="primary" data-toggle="modal" data-target="#modalNuevo" icon="fas fa-plus-circle"></x-adminlte-button>
                <a href="{{ url('/home') }}" class="btn btn-warning mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

            @php
                $heads = [

                    'Aderezo', 'Descripción', 'Acciones'

                ];
            @endphp
            
            <div class="container-fluid col-md-12 my-3">
                <x-adminlte-datatable id="aderezos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                    
                    @if( count( $aderezos ) > 0 )
                        @foreach($aderezos as $aderezo)
                                <tr>
                                    <td>{{ $aderezo->nombre }}</td>
                                    <td>{{ ( $aderezo->descripcion ? : 'Sin descripción' ) }}</td>
                                    <td>
                                        <x-adminlte-button class="editar" id="editar"  theme="info" data-toggle="modal" data-target="#modalEditar" data-id="{{ $aderezo->id }}" data-value="{{ $aderezo->nombre }}, {{ ( $aderezo->descripcion ? : 'Sin descripción' ) }}" icon="fas fa-edit"></x-adminlte-button>                                        
                                        <x-adminlte-button class="eliminar" id="eliminar"  theme="danger" data-id="{{ $aderezo->id }}" icon="fas fa-trash-alt" data-value="{{ $aderezo->nombre }}"></x-adminlte-button>
                                    </td>
                                </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="4" class="text-info"><i class="fas fa-info-circle"></i> Sin aderezos registrados</td>
                        </tr>
                    @endif
                    
                </x-adminlte-datatable>
            </div>

        </div>

    </div>

    @include('aderezos.nuevo')
    @include('aderezos.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/aderezo/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/aderezo/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/aderezo/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/aderezo/borrar.js') }}" type="text/javascript"></script>

@stop