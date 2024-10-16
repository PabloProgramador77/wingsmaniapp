<x-adminlte-modal id="modalEditar" title="Editar Platillo" theme="info" icon="fas fa-edit" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos del cargo como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreEditar" id="nombreEditar" placeholder="* Nombre de cargo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="precioEditar" id="precioEditar" placeholder="Precio de platillo">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-dollar-sign">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select name="categoriaEditar" id="categoriaEditar" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </x-adminlte-select>
                <x-adminlte-input name="salsasEditar" id="salsasEditar" placeholder="Limite de salsas">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-pepper-hot">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-textarea name="descripcionEditar" id="descripcionEditar" placeholder="Descripción del platillo (OPCIONAL)">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-align-justify"></i>
                        </div>
                    </x-slot>
                </x-adminlte-textarea>
                <x-adminlte-input-file name="portadaEditar" id="portadaEditar" placeholder="Elige un imagen de portada">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-image"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>
            <input type="hidden" name="id" id="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('editar-platillo')
            <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizar"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>