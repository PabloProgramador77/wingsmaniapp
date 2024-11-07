<x-adminlte-modal id="modalNuevo" title="Nuevo Aderezo" theme="primary" icon="fas fa-lemon" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombre" id="nombre" placeholder="Nombre de aderezo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-lemon">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="descripcion" id="descripcion" placeholder="Breve descripción de aderezo (OPCIONAL)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Registrar" id="registrar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>