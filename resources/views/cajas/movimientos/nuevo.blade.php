<x-adminlte-modal id="modalNuevo" title="Nuevo Movimiento de Caja" theme="primary" icon="fas fa-cash-register" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-select2 name="tipo" id="tipo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                    <option value="Retiro">Retiro</option>
                    <option value="Deposito">Deposito</option>
                </x-adminlte-select2>
                <x-adminlte-input name="concepto" id="concepto" placeholder="Concepto de movimiento">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-edit">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="monto" id="monto" placeholder="Monto de movimiento">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-dollar-sign">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('agregar-movimiento')
            <x-adminlte-button theme="primary" label="Registrar" id="registrar"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>