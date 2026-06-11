<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\PedidoController as BasePedidoController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PedidoController extends BasePedidoController
{
    #[OA\Post(
        path: '/api/v1/pedidos',
        tags: ['Pedidos'],
        security: [['bearerAuth' => []]],
        summary: 'Registrar un pedido',
        responses: [new OA\Response(response: 201, description: 'Pedido creado')]
    )]
    public function store(Request $request): JsonResponse
    {
        return parent::store($request);
    }

    #[OA\Get(
        path: '/api/v1/pedidos/{pedido}',
        tags: ['Pedidos'],
        security: [['bearerAuth' => []]],
        summary: 'Consultar un pedido',
        responses: [
            new OA\Response(response: 200, description: 'Pedido encontrado'),
            new OA\Response(response: 403, description: 'No autorizado'),
        ]
    )]
    public function show(Request $request, \App\Models\Pedido $pedido): JsonResponse
    {
        return parent::show($request, $pedido);
    }
}
