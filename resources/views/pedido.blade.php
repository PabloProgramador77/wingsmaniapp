<x-adminlte-modal id="modalPedido" title="Mi Pedido" size="xl" theme="primary" icon="fas fa-shopping-cart" static-backdrop scrollable>
    <div class="container-fluid row border-bottom">
        <p class="rounded bg-secondary text-center p-2 mx-2 col-lg-2 fw-semibold">{{ strtoupper( $pedido->tipo ) }}</p>
        <p class="rounded bg-info text-center p-2 mx-2 col-lg-3" id="totalPedido"><b>Total:</b> $ {{ $pedido->total }} MXN</p>
        @if ( $pedido->tipo == 'delivery' )
            <p class="rounded bg-light text-center fw-semibold col-lg-12 rounded "><i class="fas fa-info-circle"></i> A los pedidos a domicilio se les agrega al final un costo de envio, por lo que el total mostrado no es el precio final.</p>
        @endif
    </div>
    @php
        $heads = [

            'Cantidad', 'Platillo', 'Ingrediente(s) & Salsa(s)', 'Acciones'

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
                                
                                -
                            
                            @endif
                        </td>
                        <td>
                            <x-adminlte-button class="eliminar" id="eliminar" title="Borrar platillo" theme="danger" data-id="{{ $platillo->id }}" icon="fas fa-trash-alt" data-value="{{ $platillo->nombre }}"></x-adminlte-button>
                        </td>
                    </tr>

                @endforeach

            @endif

            @if ( count( $paquetesPedido ) > 0 )

                @foreach ( $paquetesPedido as $paquete )
                    
                    <tr>
                        <td>
                            <x-adminlte-button type="button" name="sumar" id="sumar" theme="primary" data-id="{{ $paquete->id }}" icon="fas fa-plus-circle" class="mx-2 sumarPaquete"></x-adminlte-button>
                            <b class="cantidadPlatillo" id="cantidadPaquete" data-id="{{ $paquete->id }}">{{ $paquete->cantidad }}</b>
                            <x-adminlte-button type="button" name="restar" id="restar" theme="danger" data-id="{{ $paquete->id }}" icon="fas fa-minus-circle" class="mx-2 restarPaquete"></x-adminlte-button>
                        </td>
                        <td>{{ $paquete->nombre }}</td>
                        <td>
                            @if ( $paquete->preparacion != NULL )
                            
                                {{ $paquete->preparacion }}

                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <x-adminlte-button class="borrar" id="borrar" title="Borrar paquete" theme="danger" data-id="{{ $paquete->id }}" icon="fas fa-trash-alt" data-value="{{ $paquete->nombre }}"></x-adminlte-button>
                        </td>
                    </tr>

                @endforeach
                
            @endif
            
        </x-adminlte-datatable>
        <input type="hidden" name="idPedido" id="idPedido" value="{{ $pedido->id }}">
    </div>
    <x-slot name="footerSlot">
        @if( count( $paquetesPedido ) > 0 || count( $platillosPedido ) > 0 )
            
            @if( auth()->user()->name === 'Invitado' )
                <x-adminlte-button theme="success" label="Enviar al restaurante" icon="fas fa-papel-plane" data-toggle="modal" data-target="#modalCliente" icon="fas fa-paper-plane" id="pedir"></x-adminlte-button>
            @else
                <x-adminlte-button theme="success" label="Enviar al restaurante" id="ordenar" icon="fas fa-paper-plane"></x-adminlte-button>
            @endif
            
        @endif
        <x-adminlte-button theme="danger" label="Cancelar Pedido" id="cancelar" class="cancelar" icon="fas fa-ban" data-id="{{ $pedido->id }}" data-value="{{ $pedido->tipo }}"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>