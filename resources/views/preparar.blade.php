@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">

            <div class="container-fluid row my-2">
                <p class="p-1 bg-info fw-semibold col-lg-12 text-center shadow"><i class="fas fa-info-circle"></i> <b>Intrucciones</b>: elige las salsas o ingredientes de tu platillo y para continuar pulsa el botón "Listo, ya lo prepare".</p>
                <div class="col-lg-5">
                    <h4 class="my-auto"><i class="fas fa-drumstick-bite"></i> Preparación de Platillo</h4>
                </div>
                <div class="col-lg-4">
                    <p class="bg-light border text-center p-2 mx-3 rounded">{{ $platillo->nombre }}</p>
                    <input type="hidden" name="id" id="id" value="{{ $pedidoHasPlatillo->id }}">
                    <input type="hidden" name="salsas" id="salsas" value="{{ $platillo->cantidadSalsas }}">
                </div>
                
            </div>

            <div class="container row">

                @if( $salsas->count() > 0 )

                    <p class="col-lg-12 text-secondary border shadow p-1 bg-warning m-2"><b>Elige la salsa de tu preferencia. Máximo {{ $platillo->cantidadSalsas }} salsas</b></p>

                    @foreach($salsas as $salsa)

                            <div class="col-md-4 col-lg-3 col-sm-6">
                                <x-adminlte-input-switch id="salsa{{ $salsa->id }}" name="salsa" label="{{ $salsa->nombre }}" data-on-text="Con {{ $salsa->nombre }}" data-off-text="Sin {{ $salsa->nombre }}" data-id="{{ $salsa->nombre }}">
                                </x-adminlte-input-switch>
                            </div>
                        
                    @endforeach

                @endif

                @if( $preparaciones->count() > 0 )

                    <p class="col-lg-12 text-secondary border shadow p-2 bg-warning m-2"><b>Elige como preparar tu platillo</b></p>
                    @foreach($preparaciones as $preparacion)

                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <x-adminlte-input-switch id="preparacion{{ $preparacion->id }}" name="preparacion" label="{{ $preparacion->nombre }}" data-on-text="{{ $preparacion->nombre }}" data-off-text="Sin preparación" data-id="{{ $preparacion->nombre }}">
                            </x-adminlte-input-switch>
                        </div>
                        
                    @endforeach

                @endif

            </div>
            <div class="container row my-2">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <x-adminlte-small-box theme="primary" url="#" url-text="Listo, ya lo prepare" id="continuar" class="continuar"></x-adminlte-small-box>
                </div>
            </div>

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>

    @if ( count( $platillo->salsas ) > 0 )
        
        <script src="{{ asset('js/pedido/preparar.js') }}" type="text/javascript"></script>

    @else
        
        <script src="{{ asset('js/pedido/preparacion.js') }}" type="text/javascript"></script>

    @endif
    

@stop