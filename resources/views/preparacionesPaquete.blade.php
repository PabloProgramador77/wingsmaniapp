<x-adminlte-modal id="modalPreparacionesPaquete" title="Preparación de Platillo" size="xl" theme="primary" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="bg-warning fw-semibold fs-6 text-center">Elige el/lo(s) ingredientes y presiona "<i class="fas fa-plus-circle"></i> Agregar"</p>
        <form novalidate>
            <x-adminlte-input name="nombrePlatilloSalsa" id="nombrePlatilloPaquetePrep" placeholder="Nombre de platillo" readonly="true">
                <x-slot name="prependSlot">
                    <div class="input-group-text tex-info">
                        <i class="fas fa-drumstick-bite"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <div class="container-fluid row mx-1 p-1 border rounded" id="contenedorPreparacionesPaquete">

            </div>
            <input type="hidden" name="idPlatilloPaquetePreparaciones" id="idPlatilloPaquetePreparaciones">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" icon="fas fa-plus-circle" id="preparacionesPlatilloPaquete" class="shadow" ></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelarPreparacionesPaquete" data-dismiss="modal" class="shadow" data-toggle="modal" data-target="#modalSalsasPaquete"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>