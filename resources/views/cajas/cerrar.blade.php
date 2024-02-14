<x-adminlte-modal id="modalCerrar" title="Cerrado de Caja" theme="warning" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">A continuación la información de la caja a cerrar</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreCaja" id="nombreCaja" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-tags"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="totalCaja" id="totalCaja" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="idCaja" id="idCaja">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('abrir-caja')
            <x-adminlte-button theme="primary" label="Cerrar" id="cerrar" icon="fas fa-lock"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-ban"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>