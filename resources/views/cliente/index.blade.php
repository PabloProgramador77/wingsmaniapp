@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-smile"></i> Clientes de Restaurante</h4>
                <p class="fs-6 fw-semibold text-secondary"><i class="fas fa-user-shield"></i> Panel de Administrador</p>
            </div>

            @php
                $heads = [

                    'Cliente', 'Email', 'Acciones'

                ];
            @endphp
            
            @can('ver-clientes')
                <div class="container-fluid col-md-12 my-3">
                    <x-adminlte-datatable id="salsas" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                        @if( count( $clientes ) > 0 )
                            @foreach($clientes as $cliente)
                                @can('ver-cliente')
                                    <tr>
                                        <td>{{ $cliente->name }}</td>
                                        <td>{{ $cliente->email }}</td>
                                        <td>
                                            <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $cliente->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                                        </td>
                                    </tr>
                                @endcan
                            @endforeach

                        @else
                            <tr>
                                <td colspan="4" class="text-info">Sin clientes registrados</td>
                            </tr>
                        @endif
                        
                    </x-adminlte-datatable>
                </div>
            @endcan

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cliente/borrar.js') }}" type="text/javascript"></script>

@stop