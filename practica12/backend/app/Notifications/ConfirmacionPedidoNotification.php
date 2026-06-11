<?php

namespace App\Notifications;

use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmacionPedidoNotification extends Notification
{
    use Queueable;

    public function __construct(public Pedido $pedido)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Confirmacion de tu pedido #{$this->pedido->id}")
            ->greeting("Hola {$notifiable->name},")
            ->line('Tu pedido fue registrado correctamente y se esta procesando.')
            ->line('Total: $'.number_format((float) $this->pedido->total, 2))
            ->line('Cuando la cola termine de ejecutarse recibiras este aviso por correo.')
            ->salutation('Gracias por comprar con nosotros.');
    }
}
