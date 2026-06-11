<?php

namespace App\Jobs;

use App\Models\Pedido;
use App\Notifications\ConfirmacionPedidoNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class EnviarConfirmacionPedido implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(public int $pedidoId)
    {
        $this->onQueue('emails');
    }

    public function handle(): void
    {
        $pedido = Pedido::with(['user', 'items.producto'])->findOrFail($this->pedidoId);

        if ($pedido->email_enviado_at) {
            return;
        }

        $pedido->user->notify(new ConfirmacionPedidoNotification($pedido));

        $pedido->forceFill([
            'estado' => 'completado',
            'email_enviado_at' => now(),
        ])->save();
    }

    public function failed(Throwable $exception): void
    {
        Log::error('No se pudo enviar la confirmacion del pedido', [
            'pedido_id' => $this->pedidoId,
            'error' => $exception->getMessage(),
        ]);

        Pedido::whereKey($this->pedidoId)->update([
            'estado' => 'cancelado',
        ]);
    }
}
