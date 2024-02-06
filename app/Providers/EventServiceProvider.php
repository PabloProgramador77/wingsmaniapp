<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrdenarPedido;
use App\Events\ConfirmarPedidoEvent;
use App\Listeners\PedidoListener;
use App\Listeners\ConfirmarPedidoListener;
use App\Events\CobrarPedidoEvent;
use App\Listeners\CobrarPedidoListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrdenarPedido::class => [
            PedidoListener::class,
        ],
        ConfirmarPedidoEvent::class => [
            ConfirmarPedidoListener::class,
        ],
        CobrarPedidoEvent::class => [
            CobrarPedidoListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
