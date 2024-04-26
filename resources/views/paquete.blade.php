@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">
            <p class="p-1 bg-light fw-semibold col-lg-12 text-center m"><i class="fas fa-info-circle"></i> A continuación, elige las salsas e ingredientes de tu platillo y para continuar pulsa el botón "Listo, ya lo prepare".</p>
            <div class="container-fluid row my-2">
                <div class="col-lg-5">
                    <h4 class="my-auto"><i class="fas fa-drumstick-bite"></i> Preparando Paquete</h4>
                </div>
                <div class="col-lg-4">
                    <p class="bg-light border text-center p-2 mx-3 rounded">{{ $paquete->nombre }}</p>
                    <input type="hidden" name="id" id="id" value="{{ $pedidoHasPaquete->id }}">
                    <input type="hidden" name="bebidas" id="bebidas" value="{{ $paquete->cantidadBebidas }}">
                    <input type="hidden" name="salsas" id="salsas" value="{{ $paquete->cantidadSalsas }}">
                </div>
                <div class="col-lg-3">
                    <x-adminlte-small-box theme="primary" url="#" url-text="Listo, ya lo prepare" id="continuar" class="continuar"></x-adminlte-small-box>
                </div>
            </div>

            <div class="form-group row">

                @if( count( $paquete->platillos ) > 0 )

                    @foreach ( $paquete->platillos as $platillo )
                    
                        <p class="col-lg-12 text-warning border shadow p-1 bg-warning m-1 text-center"><b>{{ $platillo->nombre }}</b></p>

                        @if ( count( $platillo->salsas ) > 0 )

                            <p class="col-lg-12 text-secondary border shadow p-1 bg-info m-1"><b>Elige la(s) salsa(s) de tu preferencia. Máximo {{ $paquete->cantidadSalsas }} salsa(s).</b></p>
                            
                            @foreach($platillo->salsas as $salsa)

                                <div class="col-md-4 col-lg-3">
                                    <x-adminlte-input-switch class="salsa" id="salsa{{ $salsa->id }}{{ $platillo->id }}" name="salsa" label="{{ $salsa->nombre }}" data-on-text="Con {{ $salsa->nombre }}" data-off-text="Sin {{ $salsa->nombre }}" data-id="{{ $salsa->nombre }}" data-value="{{ $platillo->nombre }}, {{ $platillo->cantidadSalsas }}">
                                    </x-adminlte-input-switch>
                                </div>
                                
                            @endforeach

                        @endif

                        @if( count( $platillo->preparaciones ) > 0 )

                            <p class="col-lg-12 text-secondary border shadow p-1 bg-info m-1"><b>Elige como preparar tu platillo</b></p>
                            
                            @foreach( $platillo->preparaciones as $preparacion )

                                <div class="col-md-4 col-lg-3">
                                    <x-adminlte-input-switch id="preparacion{{ $preparacion->id }}{{ $platillo->id }}" name="preparacion" label="{{ $preparacion->nombre }}" data-on-text="{{ $preparacion->nombre }}" data-off-text="Sin preparación" data-id="{{ $preparacion->nombre }}" data-value="{{ $platillo->nombre }}">
                                    </x-adminlte-input-switch>
                                </div>
                                
                            @endforeach

                        @endif
                        
                    @endforeach

                @endif

                @if ( count( $paquete->bebidas ) > 0 )
                    
                    <p class="col-lg-12 col-md-12 text-secondary border shadow p-1 bg-info m-1"><b>Elige las bebidas de tu paquete. Máximo {{ $paquete->cantidadBebidas }} bebida(s)</b></p>

                    @foreach ($paquete->bebidas as $bebida)
                        
                        <div class="col-md-4 col-lg-3">
                            <x-adminlte-input-switch id="bebida{{ $bebida->id }}" name="bebida" label="{{ $bebida->nombre }}" data-on-text="Con {{ $bebida->nombre }}" data-off-text="Sin {{ $bebida->nombre }}" data-id="{{ $bebida->nombre }}">
                            </x-adminlte-input-switch>
                        </div>

                    @endforeach

                @endif

            </div>

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pedido/prepararPaquete.js') }}" type="text/javascript"></script>
    
@stop