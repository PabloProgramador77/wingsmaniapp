<x-adminlte-modal id="modalEditar" title="Editar Usuario" theme="info" static-backdrop scrollable>

    <div class="container-fluid border-bottom">
        <p class="text-secondary"><b>Editar los datos como creas necesario</b>. Los campos con etiqueta * son obligatorios.</p>

        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreEditar" id="nombreEditar" placeholder="Nombre de usuario">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-tags">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="emailEditar" id="emailEditar" placeholder="Email de usuario">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-envelope">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select2 name="rolEditar" id="rolEditar" >
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-user-tag">*</i>
                        </div>
                    </x-slot>
                    @foreach($roles as $rol)
                        @if( $rol->name != 'Superadmin' && $rol->name != 'Cliente')
                            <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                        @endif
                    @endforeach
                </x-adminlte-select2>
            </div>
            <input type="hidden" name="id" id="id">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Guardar Cambios" id="actualizar"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>