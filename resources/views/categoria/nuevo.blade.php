<x-adminlte-modal id="modalNuevo" title="Nueva Categoría" theme="primary" icon="fas fa-tags" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombre" id="nombre" placeholder="Nombre de categoría">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input-file name="portada" id="portada" placeholder="Elige un imagen de portada">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-image"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>
            <input type="hidden" name="token" token="token" value="{{ csrf_token(); }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('agregar-categoria')
            <x-adminlte-button theme="primary" label="Registrar" id="registrar"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>