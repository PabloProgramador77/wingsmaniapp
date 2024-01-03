<x-adminlte-modal id="modalPedido" title="Mi Pedido" size="xl" theme="primary" static-backdrop scrollable>
    <div class="container-fluid row border-bottom">
        <p class="text-secondary col-lg-5"><b>Información de Pedido</b></p>
        <p class="rounded bg-success text-center p-2 mx-2 col-lg-3" id="totalPedido"><b>Total:</b> $ {{ $pedido->total }} MXN</p>
    </div>
    @php
        $heads = [

            'Cantidad', 'Platillo', 'Salsa/Preparación', 'Acciones'

        ];
    @endphp
    <div class="container-fluid col-md-12 my-3">
        <x-adminlte-datatable id="platillos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
            
            @if( count( $platillosPedido ) > 0 )
                @foreach($platillosPedido as $platillo)
                    <tr>
                        <td>
                            <x-adminlte-button type="button" name="sumar" id="sumar" theme="primary" data-id="{{ $platillo->id }}" icon="fas fa-plus-circle" class="mx-2 sumar"></x-adminlte-button>
                            <b class="cantidadPlatillo" id="cantidadPlatillo" data-id="{{ $platillo->id }}">{{ $platillo->cantidad }}</b>
                            <x-adminlte-button type="button" name="restar" id="restar" theme="danger" data-id="{{ $platillo->id }}" icon="fas fa-minus-circle" class="mx-2 restar"></x-adminlte-button>
                        </td>
                        <td>{{ $platillo->nombre }}</td>
                        <td>
                            @if( $platillo->preparacion != NULL )

                                {{ $platillo->preparacion }}
                                
                            @else
                                
                                Sin salsas/preparaciones
                            
                            @endif
                        </td>
                        <td>
                            <x-adminlte-button class="eliminar" id="eliminar" label="Borrar" theme="danger" data-id="{{ $platillo->id }}" icon="fas fa-trash-alt"></x-adminlte-button>
                        </td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="4" class="text-info">Sin platillos ordenados</td>
                </tr>
            @endif
            
        </x-adminlte-datatable>
    </div>
    <x-slot name="footerSlot">
        <x-adminlte-button theme="primary" label="Ordenar" id="ordenar" icon="fas fa-shopping-cart"></x-adminlte-button>
        <x-adminlte-button theme="danger" label="Cancelar" id="cancelar" data-dismiss="modal" icon="fas fa-ban"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>