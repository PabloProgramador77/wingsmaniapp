<x-adminlte-modal id="modalNuevoDomicilio" title="Nuevo Domicilio" theme="primary" icon="fas fa-map-marker-alt" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="direccion" id="direccion" placeholder="Dirección completa">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-map-marker-alt">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('agregar-domicilio')
            <x-adminlte-button theme="primary" label=" Registrar" id="registrar" icon="fas fa-save"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>