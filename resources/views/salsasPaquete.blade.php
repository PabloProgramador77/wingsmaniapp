<x-adminlte-modal id="modalSalsasPaquete" title="Preparación de Platillo" size="xl" theme="warning" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid">
        <p class="bg-light fw-semibold fs-6 text-center" data-toggle="tooltip" title="Elige la(s) salsa(s) del platillo."><i class="fas fa-info-circle"></i> Instrucciones</p>
        <form novalidate>
            <x-adminlte-input name="nombrePlatilloSalsa" id="nombrePaquetePlatilloSalsa" placeholder="Nombre de platillo" readonly="true">
                <x-slot name="prependSlot">
                    <div class="input-group-text tex-info">
                        <i class="fas fa-drumstick-bite"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <div class="container-fluid row mx-1 p-1 border rounded" id="contenedorSalsasPaquete">

            </div>
            <input type="hidden" name="idPlatilloPaqueteSalsa" id="idPlatilloPaqueteSalsa">
            <input type="hidden" name="limiteSalsasPaquete" id="limiteSalsasPaquete">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" icon="fas fa-plus-circle" id="salsasPlatilloPaquete" class="shadow"></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelarSalsasPaquete" data-dismiss="modal" class="shadow"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>