<x-adminlte-modal id="modalNuevo" title="Nuevo Usuario" theme="primary" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombre" id="nombre" placeholder="Nombre de usuario">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-user">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="email" id="email" placeholder="Email de usuario">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-envelope">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-select2 name="rol" id="rol" >
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
                <x-adminlte-input type="password" name="password" id="password" placeholder="Contraseña de acceso">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-lock">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmación de contraseña de acceso">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-lock">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label=" Registrar" id="registrar" icon="fas fa-save"></x-adminlte-button>
        <x-adminlte-button theme="danger" label=" Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-window-close"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>