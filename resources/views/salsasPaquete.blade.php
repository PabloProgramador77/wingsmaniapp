<x-adminlte-modal id="modalSalsasPaquete" title="Preparación de Platillo" size="xl" theme="primary" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid">
        <p class="bg-warning fw-semibold fs-6 text-center"><i class="fas fa-info-circle"></i> Elige la(s) salsa(s) y presiona "<i class="fas fa-plus-circle"></i> Agregar"</p>
        <form novalidate>
            <x-adminlte-input name="nombrePlatilloSalsa" id="nombrePaquetePlatilloSalsa" placeholder="Nombre de platillo" readonly="true">
                <x-slot name="prependSlot">
                    <div class="input-group-text tex-info">
                        <i class="fas fa-drumstick-bite"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <div class="container-fluid row mx-1 border rounded" id="contenedorSalsasPaquete">

            </div>
            <input type="hidden" name="idPlatilloPaqueteSalsa" id="idPlatilloPaqueteSalsa">
            <input type="hidden" name="limiteSalsasPaquete" id="limiteSalsasPaquete">
            <input type="hidden" name="nombrePlatilloPaquete" id="nombrePlatilloPaquete">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" icon="fas fa-plus-circle" id="salsasPlatilloPaquete" class="shadow" data-toggle="modal" data-target="#modalPreparacionesPaquete"></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelarSalsasPaquete" data-dismiss="modal" class="shadow" data-toggle="modal" data-target="#modalPlatillosPaquete"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>