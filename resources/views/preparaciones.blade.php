<x-adminlte-modal id="modalPreparaciones" title="Preparación de Platillo" size="xl" theme="warning" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="bg-warning">Elige el/los ingrediente(s) y presiona "<i class="fas fa-plus-circle"></i> Agregar"</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombrePlatilloPrep" id="nombrePlatilloPrep" placeholder="Nombre de platillo" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-drumstick-bite"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <div class="container-fluid row p-1 border rounded" id="contenedorPreparacionesPlatillo">

            </div>
            <input type="hidden" name="idPlatilloPrep" id="idPlatilloPrep">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" icon="fas fa-plus-circle" id="ingredientesPlatillo"></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelarIngredientes" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>