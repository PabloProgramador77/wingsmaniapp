<x-adminlte-modal id="modalEnvios" title="Envios de Pedido(s)" size="md" theme="success" icon="fas fa-truck" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige el envio para el pedido.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="cliente" id="cliente" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-smile"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="domicilio" id="domicilio" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="total" id="total" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <p class="text-secondary border-bottom">Envio(s)</p>
            <div class="form-group row">

                @if ( count( $envios ) > 0 )
    
                    @foreach($envios as $envio)

                        <div class="col-md-4 col-lg-4">
                            <x-adminlte-input-switch id="envio{{ $envio->id }}" name="envio" label="{{ $envio->nombre }}" data-on-text="{{ $envio->monto }}" data-off-text="{{ $envio->monto }}" data-id="{{ $envio->id }}">
                            </x-adminlte-input-switch>
                        </div>

                    @endforeach

                @else

                    <div class="col-md-12">
                        <p class="fs-5 fw-semibold text-center text-danger"><i class="fas fa-info-circle"></i> Sin envios registrados. <a href="{{ url('envios') }}">Registralos aquí</a></p>
                    </div>
                    
                @endif

            </div>
            <input type="hidden" name="id" token="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>