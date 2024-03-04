<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Pedido;

class CobrarPedidoNotification extends Notification
{
    use Queueable;
    public $pedido;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if( $this->pedido->tipo == 'delivery' ){

            $mensaje = 'Tu pedido esta listo para ser enviado a tu domicilio.';

        }else{

            $mensaje = 'Tu pedido esta listo para que lo recoges en el restaurante.';

        }

        return [
            
            'id' => $this->pedido->id,
            'total' => $this->pedido->total,
            'tipo' => $this->pedido->tipo,
            'idCliente' => $this->pedido->idCliente,
            'cliente' => $this->pedido->cliente->name,
            'fecha' => $this->pedido->update_at,
            'mensaje' => $mensaje,

        ];
    }
}
