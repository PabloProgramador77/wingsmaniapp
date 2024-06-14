@extends('home')
@section('contenido')
    <div class="container-fluid col-md-12 p-2 bg-white">

        <div class="container-fluid row col-md-12 border-bottom p-2">
            <p class="p-1 bg-info fw-semibold col-lg-12 text-center shadow"><i class="fas fa-info-circle"></i> <b>Instrucciones:</b> a continuación elige el platillo del paquete que debes preparar.</p>
            <div class="container-fluid row my-2">
                <div class="col-lg-5">
                    <h4 class="my-auto"><i class="fas fa-drumstick-bite"></i> Paquete / Promoción</h4>
                </div>
                <div class="col-lg-4">
                    <p class="bg-light border text-center p-2 mx-3 rounded">{{ $paquete->nombre }} - $ {{ $paquete->precio }}</p>
                </div>
                
            </div>

            <div class="container-fluid form-group row">

                @if( count( $paquete->platillos ) > 0 )

                    @foreach ( $paquete->platillos as $platillo )

                        @if ( count( $platillo->salsas ) > 0 || count( $platillo->preparaciones ) > 0 )
                            
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <x-adminlte-small-box title="{{ $platillo->nombre }}" text="Elige la(s) salsa(s) y/o ingrediente(s) del platillo" icon="fas fa-drumstick-bite" theme="warning" url="{{ url('/paquete/platillo/preparar') }}/{{ $pedidoHasPaquete->id }}/{{ $platillo->id }}" url-text="Elegir salsa(s) e ingrediente(s)"></x-adminlte-small-box>
                            </div>
                        @else

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <x-adminlte-small-box title="{{ $platillo->nombre }}" text="Sin ingredientes para elegir" icon="fas fa-drumstick-bite" theme="secondary" ></x-adminlte-small-box>
                            </div>

                        @endif
                        
                    @endforeach

                @endif

                @if ( count( $paquete->bebidas ) > 0 )

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <x-adminlte-small-box title="Bebidas de Paquete/Promoción" text="Elige la(s) bebida(s) del paquete/promoción" icon="fas fa-wine-bottle" theme="info" url-text="Elegir bebida(s)" url="{{ url('/paquete/bebida/preparar') }}/{{ $paquete->id }}"></x-adminlte-small-box>
                    </div>

                @endif

                @if( session()->get('conteoPlatillo') > 0 )
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <x-adminlte-small-box title="Continuar"  id="continuar" class="continuar" icon="fas fa-forward" text="Debes preparar los platillos del paquete para continuar" theme="danger"></x-adminlte-small-box>
                    </div>
                @else
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <x-adminlte-small-box title="Continuar" url="{{ url('/pedido/menu') }}"  id="continuar" class="continuar" icon="fas fa-forward" text="Pulsa aquí para continuar con tu pedido" url-text="Continuar con pedido" theme="success" disabled="true"></x-adminlte-small-box>
                    </div>
                @endif
            </div>
            
            

        </div>

    </div>

    <script src="{{ asset('jquery-3.7.js') }}" type="text/javascript"></script>
    <script src="{{ asset('sweetAlert.js') }}" type="text/javascript"></script>
    
@stop