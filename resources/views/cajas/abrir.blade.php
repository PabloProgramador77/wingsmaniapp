<x-adminlte-modal id="modalAbrir" title="Apertura de Caja" theme="primary" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreCaja" id="nombreCaja" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-tags"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="monto" id="monto" placeholder="Monto de apertura en caja">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-dollar-sign">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idCaja" id="idCaja">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('abrir-caja')
            <x-adminlte-button theme="primary" label="Abrir" id="abrir" icon="fas fa-lock-open"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-ban"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>