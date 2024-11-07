<x-adminlte-modal id="modalAderezo" title="Aderezo(s) de Platillo" size="xl" theme="warning" icon="fas fa-lemon" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige el/los aderezo(s) que deseas agregar al platillo.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="platilloAderezos" id="platilloAderezos" placeholder="Nombre de platillo" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-drumstick-bite"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <p class="text-secondary border-bottom">Aderezo(s)</p>
            <div class="form-group row">

                @foreach($aderezos as $aderezo)

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <x-adminlte-input-switch id="aderezo{{ $aderezo->id }}" name="aderezo" label="{{ $aderezo->nombre }}" data-on-text="Con {{ $aderezo->nombre }}" data-off-text="Sin {{ $aderezo->nombre }}" data-id="{{ $aderezo->id }}">
                        </x-adminlte-input-switch>
                    </div>
                    
                @endforeach
            </div>
            <input type="hidden" name="idPlatilloAderezo" id="idPlatilloAderezo">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Guardar" id="agregarAderezos" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>