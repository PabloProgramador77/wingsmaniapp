<x-adminlte-modal id="modalPedido" title="Mi Pedido" size="xl" theme="primary" icon="fas fa-shopping-cart" static-backdrop scrollable>
    <div class="container-fluid row border-bottom">
        @if ( $pedido->tipo == 'delivery' )
            <p class="rounded bg-warning text-center fs-6 fw-semibold col-lg-12 rounded "><i class="fas fa-info-circle"></i> Los pedidos a domicilio tienen un costo de envio, por lo que el total mostrado no es el total final.</p>
        @endif
        <p class="rounded border text-center p-1 col-lg-4 col-md-6 col-sm-12 fw-semibol"><b>Cliente:</b> {{ $pedido->cliente->name }}</p>
        <p class="rounded border text-center p-1 col-lg-4 col-md-6 col-sm-12 fw-semibold"><b>Tipo de Pedido:</b> {{ strtoupper( $pedido->tipo ) }}</p>
        <p class="rounded bg-info text-center p-1 col-lg-4 col-md-6 col-sm-12" id="totalPedido"><b>Total de Pedido:</b> $ {{ $pedido->total }} MXN</p>
       
    </div>
    @php
        $heads = [

            'Cantidad', 'Platillo', 'Ingrediente(s) & Salsa(s)', 'Acciones'

        ];
    @endphp
    
    <div class="container-fluid col-lg-12 col-md-12 col-sm-12 my-3">
        <x-adminlte-datatable id="platillos" :heads="$heads" theme="light" striped hoverable bordered compressed beautify>
            
            @if( count( $platillosPedido ) > 0 )

                @foreach($platillosPedido as $platillo)

                    <tr>
                        <td>
                            <x-adminlte-button type="button" name="sumar" id="sumar" theme="primary" data-id="{{ $platillo->id }}" icon="fas fa-plus-circle" class="mx-1 sumar"></x-adminlte-button>
                            <b class="cantidadPlatillo" id="cantidadPlatillo" data-id="{{ $platillo->id }}">{{ $platillo->cantidad }}</b>
                            <x-adminlte-button type="button" name="restar" id="restar" theme="danger" data-id="{{ $platillo->id }}" icon="fas fa-minus-circle" class="mx-1 restar"></x-adminlte-button>
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
                            <x-adminlte-button type="button" name="sumar" id="sumar" theme="primary" data-id="{{ $paquete->id }}" icon="fas fa-plus-circle" class="mx-1 sumarPaquete"></x-adminlte-button>
                            <b class="cantidadPlatillo" id="cantidadPaquete" data-id="{{ $paquete->id }}">{{ $paquete->cantidad }}</b>
                            <x-adminlte-button type="button" name="restar" id="restar" theme="danger" data-id="{{ $paquete->id }}" icon="fas fa-minus-circle" class="mx-1 restarPaquete"></x-adminlte-button>
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
                <x-adminlte-button class="shadow" theme="success" label="Enviar Pedido" icon="fas fa-papel-plane" data-toggle="modal" data-target="#modalCliente" icon="fas fa-paper-plane" id="pedir"></x-adminlte-button>
            @else
                <x-adminlte-button class="shadow" theme="success" label="Enviar Pedido" id="ordenar" icon="fas fa-paper-plane"></x-adminlte-button>
            @endif
            
        @endif
        <x-adminlte-button class="shadow" theme="danger" label="Cancelar Pedido" id="cancelar" class="cancelar" icon="fas fa-ban" data-id="{{ $pedido->id }}" data-value="{{ $pedido->tipo }}"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>