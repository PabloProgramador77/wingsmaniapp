<x-adminlte-modal id="modalPlatillos" title="Platillo(s) de Paquete" size="xl" theme="secondary" icon="fas fa-wine-bottle" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige el/los platillo(s) que deseas agregar al paquete.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombrePaquete" id="nombrePaquete" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-drumstick-bite"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <p class="text-secondary border-bottom">Platillo(s)</p>
            <div class="form-group row">

                @foreach($platillos as $platillo)

                    <div class="form-check form-switch col-md-4 col-lg-3 my-1">
                        <input class="form-check-input-switch" type="checkbox" role="switch" name="platillo" id="{{ $platillo->id }}" value="{{ $platillo->id }}">
                        <label class="form-check-label" for="{{ $platillo->id }}">{{ $platillo->nombre }}</label>
                    </div> 
                    
                @endforeach
            </div>
            <input type="hidden" name="id" token="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="agregar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>