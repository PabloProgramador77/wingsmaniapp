<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Models\Pedido;
use App\Notifications\NuevoPedido;
use Illuminate\Support\Facades\Notification;

class PedidoListener
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

        $usuarios = User::role(['Gerente', 'Mesero'])->get();

        foreach( $usuarios as $usuario ){

            Notification::send( $usuario, new NuevoPedido($event->pedido) );

        }

    }
}
