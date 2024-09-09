<x-adminlte-modal id="modalPlatillosPaquete" title="Preparación de Paquete" size="xl" theme="warning" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid">
        <form novalidate>
            <x-adminlte-input name="nombrePaquetePrep" id="nombrePaquetePrep" readonly="true">
                <x-slot name="prependSlot">
                    <div class="input-group-text tex-info">
                        <i class="fas fa-drumstick-bite"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <input type="hidden" name="idPaquete" id="idPaquete">
            <input type="hidden" name="limiteSalsasPaquete" id="limiteSalsasPaquete">
            <input type="hidden" name="limiteBebidasPaquete" id="limiteBebidasPaquete">
            <input type="hidden" name="limiteEditablesPaquete" id="limiteEditablesPaquete">

            <div id="contenedorPlatillosPaquete" class="container-fluid row" >
                
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelarPaquete" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>