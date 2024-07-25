<x-adminlte-modal id="modalCliente" title="Datos de Cliente" theme="warning" icon="fas fa-user" static-backdrop scrollable>
    <div class="container-fluid border-bottom">
        <p class="text-secondary">Por favor captura tus datos para poder entregar tu pedido. Los campos con etiqueta * son obligatorios.</p>
        <form novalidate>
            <div class="form-group">
                <x-adminlte-input name="nombreCliente" id="nombreCliente" placeholder="Nombre de cliente" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-user">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="telefonoCliente" id="telefonoCliente" placeholder="Telefono de cliente" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-phone">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <x-adminlte-input name="domicilioCliente" id="domicilioCliente" placeholder="Domicilio de cliente" required>
                    <x-slot name="prependSlot">
                        <div class="input-group-text tex-info">
                            <i class="fas fa-map-marker-alt">*</i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
            </div>
            <input type="hidden" name="token" token="token" value="{{ csrf_token(); }}">
        </form>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="success" label="Enviar Pedido" id="ordenarPedido" icon="fas fa-paper-plane"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cerrar" data-dismiss="modal" icon="fas fa-ban" id="cancelarCliente"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>