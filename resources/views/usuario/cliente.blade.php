@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="col-md-7">
                <h4 class="my-auto"><i class="fas fa-smile"></i> Perfil de Cliente</h4>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/home') }}" class="btn btn-success mx-1 rounded">
                    <i class="fas fa-home"></i> Inicio
                </a>
            </div>

        </div>

        <div class="container-fluid col-md-12 row p-2">

            <div class="col-md-5 m-1 p-2 rounded shadow">
                <div class="form-group">
                    <img src="{{ url('img/logo_min.png') }}" alt="" width="200px" height="200px" class="p-2 rounded m-auto d-block">
                    <p class="text-center" style="font-size: 24px;"><b>{{ $cliente->name }}</b></p>
                    <p class="text-center text-secondary" style="font-size: 18px;">{{ $cliente->email }}</p>
                </div>
            </div>

            <div class="col-md-6 m-1 p-2">
                <form novalidate>
                    <div class="form-group">
                        <x-adminlte-input name="nombreCliente" id="nombreCliente" placeholder="Nombre de cliente" value="{{ $cliente->name }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-warning">
                                    <i class="fas fa-user"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                        <x-adminlte-input name="emailCliente" id="emailCliente" placeholder="Email de cliente" value="{{ $cliente->email }}">
                            <x-slot name="prependSlot">
                                <div class="input-group-text text-warning">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input>
                    </div>
                    <div class="form-group">
                        <x-adminlte-button theme="primary" label="Guardar cambios" id="guardar" icon="fas fa-save"></x-adminlte-button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid row col-md-12 p-2">
            <div class="col-md-6 my-2">
                @can('agregar-domicilio')
                    <div class="col-md-12">
                        <x-adminlte-button label="Agregar domicilio" theme="primary" data-toggle="modal" data-target="#modalNuevoDomicilio" icon="fas fa-plus-circle"></x-adminlte-button>
                    </div>
                @endcan
                @php
                    $heads = [

                        'Dirección', 'Acciones'

                    ];
                @endphp
                
                @can('ver-domicilios')
                    <div class="container-fluid col-md-12 my-3">
                        <x-adminlte-datatable id="domicilios" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                            @if( count($cliente->domicilios) > 0 )

                                @foreach($cliente->domicilios as $domicilio)
                                    @can('ver-domicilio')
                                        <tr>
                                            <td>{{ $domicilio->direccion }}</td>
                                            <td>
                                                @can('editar-domicilio')
                                                    <x-adminlte-button class="editarDomicilio" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditarDomicilio" data-id="{{ $domicilio->id }}" icon="fas fa-pen"></x-adminlte-button>
                                                @endcan
                                                @can('borrar-domicilio')
                                                    <x-adminlte-button class="eliminarDomicilio" id="eliminar" label="Borrar" theme="danger" data-id="{{ $domicilio->id }}" icon="fas fa-trash-alt" data-value="{{ $domicilio->direccion }}"></x-adminlte-button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endcan
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="4" class="text-info">Sin domicilios registrados</td>
                                </tr>
                            @endif
                            
                        </x-adminlte-datatable>
                    </div>
                @endcan
            </div>

            <div class="col-md-6 my-2">
                @can('agregar-telefono')
                    <div class="col-md-12">
                        <x-adminlte-button label="Agregar telefono" theme="primary" data-toggle="modal" data-target="#modalNuevoTelefono" icon="fas fa-plus-circle"></x-adminlte-button>
                    </div>
                @endcan
                @php
                    $heads = [

                        'Número telefonico', 'Acciones'

                    ];
                @endphp
                
                @can('ver-telefonos')
                    <div class="container-fluid col-md-12 my-3">
                        <x-adminlte-datatable id="telefonos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
                        
                            @if( count($cliente->telefonos) > 0 )
                                @foreach($cliente->telefonos as $telefono)
                                    @can('ver-telefono')
                                    <tr>
                                        <td>{{ $telefono->nunmero }}</td>
                                        <td>
                                            @can('editar-telefono')
                                                <x-adminlte-button class="editarTelefono" id="editar" label="Editar" theme="info" data-toggle="modal" data-target="#modalEditarTelefono" data-id="{{ $telefono->id }}" icon="fas fa-pen"></x-adminlte-button>
                                            @endcan
                                            @can('borrar-telefono')
                                                <x-adminlte-button class="eliminarTelefono" id="eliminar" label="Borrar" theme="danger" data-id="{{ $telefono->id }}" icon="fas fa-trash-alt" data-value="{{ $telefono->numero }}"></x-adminlte-button>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endcan
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="4" class="text-info">Sin telefonos registrados</td>
                                </tr>
                            @endif
                            
                        </x-adminlte-datatable>
                    </div>
                @endcan
            </div>

        </div>

    </div>

    @include('usuario.domicilio')
    @include('usuario.telefono')
    @include('usuario.domicilio.editar')
    @include('usuario.telefono.editar')

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/domicilio/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/domicilio/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/domicilio/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/domicilio/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/telefono/agregar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/telefono/buscar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/telefono/actualizar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/telefono/borrar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/cliente/actualizar.js') }}" type="text/javascript"></script>
    
@stop