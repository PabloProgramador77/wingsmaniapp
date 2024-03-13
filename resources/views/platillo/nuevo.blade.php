<x-adminlte-modal id="modalNuevo" title="Nuevo Platillo" theme="primary" icon="fas fa-user" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombre" id="nombre" placeholder="Nombre de platillo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-drumstick-bite">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="precio" id="precio" placeholder="Precio de platillo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-dollar-sign">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select2 name="categoria" id="categoria" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </x-adminlte-select2>
                
                <x-adminlte-input name="salsas" id="salsas" placeholder="Limite de salsas">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-pepper-hot">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-textarea name="descripcion" id="descripcion" placeholder="Descripción del platillo (OPCIONAL)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>
            </div>
            <input type="hidden" name="token" token="token" value="{{ csrf_token(); }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('agregar-platillo')
            <x-adminlte-button theme="primary" label="Registrar" id="registrar"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>