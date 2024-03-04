<x-adminlte-modal id="modalPreparacion" title="Salsa(s) de Platillo" size="xl" theme="primary" icon="fas fa-pepper-hot" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige la(s) preparacion(es) que deseas agregar al platillo.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombrePlatilloPrep" id="nombrePlatilloPrep" placeholder="Nombre de platillo" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-drumstick-bite"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <p class="text-secondary border-bottom">Preparacion(es)</p>
            <div class="form-group row">

                @foreach($preparaciones as $preparacion)

                    <div class="col-md-4 col-lg-3">
                        <x-adminlte-input-switch id="preparacion{{ $preparacion->id }}" name="preparacion" label="{{ $preparacion->nombre }}" data-on-text="{{ $preparacion->nombre }}" data-off-text="Sin preparación" data-id="{{ $preparacion->id }}">
                        </x-adminlte-input-switch>
                    </div>
                    
                @endforeach
            </div>
            <input type="hidden" name="id" token="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Agregar" id="preparar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>