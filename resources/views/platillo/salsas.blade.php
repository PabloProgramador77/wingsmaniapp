<x-adminlte-modal id="modalSalsa" title="Salsa(s) de Platillo" size="xl" theme="secondary" icon="fas fa-wine-bottle" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige la(s) salsa(s) que deseas agregar al platillo.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombrePlatillo" id="nombrePlatillo" placeholder="Nombre de platillo" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-drumstick-bite"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <p class="text-secondary border-bottom">Salsa(s)</p>
            <div class="form-group row">

                @foreach($salsas as $salsa)

                    <div class="col-md-4 col-lg-3">
                        <x-adminlte-input-switch id="salsa{{ $salsa->id }}" name="salsa" label="{{ $salsa->nombre }}" data-on-text="Con {{ $salsa->nombre }}" data-off-text="Sin {{ $salsa->nombre }}" data-id="{{ $salsa->id }}">
                        </x-adminlte-input-switch>
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