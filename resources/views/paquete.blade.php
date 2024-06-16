@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">
            <p class="p-1 bg-info fw-semibold col-lg-12 text-center shadow"><i class="fas fa-info-circle"></i> <b>Instrucciones:</b> elige las salsas o ingredientes de tu platillo y para continuar pulsa el botón "Listo, ya lo prepare".</p>
            <div class="container-fluid row my-2">
                <div class="col-lg-5">
                    <h4 class="my-auto"><i class="fas fa-drumstick-bite"></i> Preparando Platillo de Paquete</h4>
                </div>
                <div class="col-lg-4">
                    <p class="bg-light border text-center p-2 mx-3 rounded">{{ $paquete->nombre }} -> {{ $platillo->nombre }}</p>
                    <input type="hidden" name="id" id="id" value="{{ $paquete->id }}">
                    <input type="hidden" name="idPedidoPaquete" id="idPedidoPaquete" value="{{ session()->get('idPedidoPaquete') }}">
                    <input type="hidden" name="bebidas" id="bebidas" value="{{ $paquete->cantidadBebidas }}">
                    <input type="hidden" name="salsas" id="salsas" value="{{ $paquete->cantidadSalsas }}">
                </div>
                
            </div>

            <div class="form-group row">

            @if ( count( $platillo->salsas ) > 0 )

                <p class="col-lg-12 text-secondary border shadow p-1 bg-info m-1"><b>Elige la(s) salsa(s) de tu preferencia. Máximo {{ $paquete->cantidadSalsas }} salsa(s).</b></p>

                @foreach($platillo->salsas as $salsa)

                    <div class="col-md-4 col-lg-3 col-sm-6">
                        <x-adminlte-input-switch class="salsa" id="salsa{{ $salsa->id }}{{ $platillo->id }}" name="salsa" label="{{ $salsa->nombre }}" data-on-text="Con {{ $salsa->nombre }}" data-off-text="Sin {{ $salsa->nombre }}" data-id="{{ $salsa->nombre }}" data-value="{{ $platillo->nombre }}">
                        </x-adminlte-input-switch>
                    </div>
                    
                @endforeach 

                <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
                <script src="{{ asset('js/pedido/prepararPaqueteSalsas.js') }}" type="text/javascript"></script>

            @endif

            @if( count( $platillo->preparaciones ) > 0 )

                <p class="col-lg-12 text-secondary border shadow p-1 bg-info m-1"><b>Elige como preparar tu platillo</b></p>

                @foreach( $platillo->preparaciones as $preparacion )

                    <div class="col-md-4 col-lg-3">
                        <x-adminlte-input-switch id="preparacion{{ $preparacion->id }}{{ $platillo->id }}" name="preparacion" label="{{ $preparacion->nombre }}" data-on-text="{{ $preparacion->nombre }}" data-off-text="Sin preparación" data-id="{{ $preparacion->nombre }}" data-value="{{ $platillo->nombre }}">
                        </x-adminlte-input-switch>
                    </div>
                    
                @endforeach

                <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
                <script src="{{ asset('js/pedido/prepararPaquetePreparaciones.js') }}" type="text/javascript"></script>

            @endif

            </div>
            
            <div class="container row my-2">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <x-adminlte-small-box theme="primary" url="#" url-text="Listo, ya lo prepare" id="continuar" class="continuar"></x-adminlte-small-box>
                </div>
            </div>

        </div>

    </div>

    
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    
    
@stop