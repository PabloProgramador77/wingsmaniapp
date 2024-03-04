<x-adminlte-modal id="modalNuevo" title="Nuevo Corte de Caja" theme="primary" icon="fas fa-cash-register" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos se llena automáticamente.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombre" id="nombre" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-edit"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="total" id="total" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('agregar-corte')
            <x-adminlte-button theme="primary" label="Hacer Corte" id="registrar"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>