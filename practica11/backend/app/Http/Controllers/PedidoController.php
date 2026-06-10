<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarConfirmacionPedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:productos,id'],
            'items.*.cantidad' => ['required', 'integer', 'min:1'],
        ]);

        $user = $request->user();

        $pedido = DB::transaction(function () use ($data, $user): Pedido {
            $productos = Producto::query()
                ->whereIn('id', collect($data['items'])->pluck('id'))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $total = 0;

            foreach ($data['items'] as $item) {
                $producto = $productos->get($item['id']);

                if (!$producto) {
                    throw new HttpResponseException(response()->json([
                        'message' => 'Producto no encontrado',
                    ], 404));
                }

                if ($producto->stock < $item['cantidad']) {
                    throw new HttpResponseException(response()->json([
                        'message' => "Stock insuficiente para {$producto->nombre}",
                    ], 422));
                }

                $total += $producto->precio * $item['cantidad'];
            }

            $pedido = Pedido::create([
                'user_id' => $user->id,
                'total' => $total,
                'estado' => 'procesando',
            ]);

            foreach ($data['items'] as $item) {
                $producto = $productos->get($item['id']);

                $pedido->items()->create([
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio,
                ]);

                $producto->decrement('stock', $item['cantidad']);
            }

            return $pedido;
        });

        EnviarConfirmacionPedido::dispatch($pedido->id)
            ->delay(now()->addSeconds(5))
            ->afterCommit();

        return response()->json([
            'message' => 'Pedido registrado. Procesando confirmacion por correo.',
            'data' => $pedido->load(['items.producto', 'user']),
        ], 201);
    }

    public function show(Request $request, Pedido $pedido): JsonResponse
    {
        if ($request->user()->id !== $pedido->user_id && !$request->user()->is_admin) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return response()->json([
            'message' => 'Pedido consultado correctamente',
            'data' => $pedido->load(['items.producto', 'user']),
        ], 200);
    }
}
