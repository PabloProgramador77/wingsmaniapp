<x-adminlte-modal id="modalNuevo" title="Nueva Caja" theme="primary" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombre" id="nombre" placeholder="Nombre de caja">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="total" id="total" placeholder="Total de caja">
                    <x-slot name="prependSlot">
                        <div class="input-group-text text-info">
                            <i class="fas fa-dollar-sign">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="token" token="token" value="{{ csrf_token(); }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('agregar-caja')
            <x-adminlte-button theme="primary" label="Registrar" id="registrar"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>