<x-adminlte-modal id="modalPreparaciones" title="Preparación de Platillo" size="xl" theme="warning" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="bg-secondary p-1 shadow">Elige la(s) salsa(s) y/o ingrediente(s) de tu platillo y para continuar pulsa el botón "<i class="fas fa-blender"></i> Preparar"</p>
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
            <div class="container-fluid row p-1 border rounded" id="contenedorSalsasPlatillo">

            </div>
            <div class="container-fluid row p-1 border rounded" id="contenedorPreparacionesPlatillo">

            </div>
            <input type="hidden" name="idPlatillo" id="idPlatillo">
            <input type="hidden" name="limiteSalsas" id="limiteSalsas">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Preparar" icon="fas fa-blender" id="prepararPlatillo"></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>