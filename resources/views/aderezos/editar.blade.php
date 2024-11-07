<x-adminlte-modal id="modalEditar" title="Editar Preparación" theme="info" icon="fas fa-edit" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos de la preparación como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreEditar" id="nombreEditar" placeholder="* Nombre de aderezo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-lemon">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="descripcionEditar" id="descripcionEditar" placeholder="Breve descripción de aderezo (OPCIONAL)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="id" id="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>