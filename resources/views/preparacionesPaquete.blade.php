<x-adminlte-modal id="modalPreparacionesPaquete" title="Preparación de Paquete" size="xl" theme="warning" icon="fas fa-dumpster-fire" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="bg-secondary p-1 shadow">Desliza a los lados para ver los diferentes platillos y para terminar pulsa el botón "<i class="fas fa-blender"></i> Preparar"</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombrePaquetePrep" id="nombrePaquetePrep" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-drumstick-bite"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            
            <input type="hidden" name="idPaquete" id="idPaquete">
            <input type="hidden" name="limiteSalsasPaquete" id="limiteSalsasPaquete">
            <input type="hidden" name="limiteBebidasPaquete" id="limiteBebidasPaquete">
            <input type="hidden" name="limiteEditablesPaquete" id="limiteEditablesPaquete">

            <div id="carouselPlatillos" class="carousel slide px-5 border" data-interval="false">
                <div class="carousel-inner" id="contenedorPlatillosPaquete">
                    
                </div>
                <x-adminlte-button icon="fas fa-chevron-left" class="carousel-control-prev" data-target="#carouselPlatillos" data-slide="prev" style="background-color: #ffe970; color: black; width: 30px; z-index: 1;">
                </x-adminlte-button>
                <x-adminlte-button icon="fas fa-chevron-right" class="carousel-control-next" data-target="#carouselPlatillos" data-slide="next" style="background-color: #ffe970; color: black; width: 30px; z-index: 1;">
                </x-adminlte-button>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Preparar" icon="fas fa-blender" id="prepararPaquete" disabled="true"></x-adminlte-button>
        <x-adminlte-button theme="danger" icon="fas fa-times-circle" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>