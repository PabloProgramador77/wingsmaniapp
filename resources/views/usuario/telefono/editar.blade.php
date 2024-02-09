<x-adminlte-modal id="modalEditarTelefono" title="Editar Telefono" theme="info" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="telefonoEditar" id="telefonoEditar" placeholder="Número telefonico">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-phone-alt">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idTelefono" id="idTelefono">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('editar-telefono')
            <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizarTelefono"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>