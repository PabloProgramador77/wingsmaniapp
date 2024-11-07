<x-adminlte-modal id="modalAderezos" title="Preparación de Platillo" size="xl" theme="warning" icon="fas fa-lemon" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="bg-warning fw-semibold fs-6 text-center">Elige el/los aderezo(s) y presiona "<i class="fas fa-plus-circle"></i> Agregar"</p>
        <form novalidate>
            <x-adminlte-input name="nombrePlatilloAderezo" id="nombrePlatilloAderezo" placeholder="Nombre de platillo" readonly="true">
                <x-slot name="prependSlot">
                    <div class="input-group-text tex-info">
                        <i class="fas fa-drumstick-bite"></i>
                    </div>
                </x-slot>
            </x-adminlte-input>
            <div class="container-fluid row mx-1 p-1 border rounded" id="contenedorAderezosPlatillo">

            </div>
            <input type="hidden" name="idPlatilloAderezo" id="idPlatilloAderezo">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" icon="fas fa-plus-circle" id="aderezosPlatillo" class="shadow"></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelarAderezos" data-dismiss="modal" class="shadow"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>