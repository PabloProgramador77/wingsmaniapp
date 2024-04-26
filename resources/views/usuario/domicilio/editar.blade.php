<x-adminlte-modal id="modalEditarDomicilio" title="Editar Domicilio" theme="info" icon="fas fa-edit" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Edita el domicilio para entregar tus pedidos</b>.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="direccionEditar" id="direccionEditar" placeholder="Dirección completa">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-map-marker-alt">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idDomicilio" id="idDomicilio">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('editar-domicilio')
            <x-adminlte-button theme="primary" label=" Guardar cambios" id="actualizar" icon="fas fa-save"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-ban"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>