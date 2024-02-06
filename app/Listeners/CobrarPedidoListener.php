<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\CobrarPedidoNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Pedido;

class CobrarPedidoListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $usuario = User::find( $event->pedido->idCliente );

        Notification::send( $usuario, new CobrarPedidoNotification( $event->pedido ) );
    }
}
