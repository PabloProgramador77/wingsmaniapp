<x-adminlte-modal id="modalBebidasPaquete" title="Preparación de Platillo" size="xl" theme="warning" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="bg-light fw-semibold fs-6 text-center">Elige la(s) bebida(s) de tu paquete y presiona el botón "<i class="fas fa-plus-circle"></i> Agregar"</p>
        <form novalidate>
            <x-adminlte-input name="nombrePlatilloBebidas" id="nombrePlatilloBebidas" placeholder="Nombre de platillo" readonly="true">
                <x-slot name="prependSlot">
                    <div class="input-group-text tex-info">
                        <i class="fas fa-drumstick-bite"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <div class="container-fluid row mx-1 p-1 border rounded" id="contenedorBebidasPaquete">

            </div>
            <input type="hidden" name="idPlatilloPaqueteBebidas" id="idPlatilloPaqueteBebidas">
            <input type="hidden" name="limiteBebidasPaquete" id="limiteBebidasPaquete">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" icon="fas fa-plus-circle" id="bebidasPlatilloPaquete" class="shadow"></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelarBebidasPaquete" data-dismiss="modal" class="shadow"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>