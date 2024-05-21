<x-adminlte-modal id="modalPermisos" title="Permisos de Rol de Usuario" size="xl" theme="primary" icon="fas fa-users-cog" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Elige los permisos que deseas agregar al rol.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreRol" id="nombreRol" readonly="true">
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-user-tag"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <p class="text-secondary border-bottom">Permisos de Usuario</p>
            <div class="form-group row">

                @foreach($permisos as $permiso)
                    @can('asignar-permiso')
                    <div class="form-check form-switch col-md-4 col-lg-3 my-1">
                        <input class="form-check-input-switch" type="checkbox" role="switch" name="permiso" id="{{ $permiso->id }}" value="{{ $permiso->name }}">
                        <label class="form-check-label" for="{{ $permiso->id }}">{{ $permiso->name }}</label>
                    </div> 
                    @endcan
                @endforeach
            </div>
            <input type="hidden" name="idRol" id="idRol">
        </form>
    </div>
    <x-slot name="footerSlot">
        @can('asignar-permisos')
            <x-adminlte-button theme="primary" label="" id="permitir"></x-adminlte-button>
        @endcan
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>