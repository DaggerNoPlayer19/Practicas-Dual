<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ProductoController as BaseProductoController;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ProductoController extends BaseProductoController
{
    #[OA\Get(
        path: '/api/v1/productos',
        tags: ['Productos'],
        summary: 'Listar productos',
        responses: [new OA\Response(response: 200, description: 'Listado de productos')]
    )]
    public function index(Request $request): AnonymousResourceCollection
    {
        return parent::index($request);
    }

    #[OA\Post(
        path: '/api/v1/productos',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        summary: 'Crear un producto',
        responses: [new OA\Response(response: 201, description: 'Producto creado')]
    )]
    public function store(Request $request): ProductoResource
    {
        return parent::store($request);
    }

    #[OA\Get(
        path: '/api/v1/productos/{id}',
        tags: ['Productos'],
        summary: 'Consultar un producto',
        responses: [
            new OA\Response(response: 200, description: 'Producto encontrado'),
            new OA\Response(response: 404, description: 'Producto no encontrado'),
        ]
    )]
    public function show(string $id): ProductoResource|JsonResponse
    {
        return parent::show($id);
    }

    #[OA\Put(
        path: '/api/v1/productos/{id}',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        summary: 'Actualizar un producto',
        responses: [
            new OA\Response(response: 200, description: 'Producto actualizado'),
            new OA\Response(response: 404, description: 'Producto no encontrado'),
        ]
    )]
    public function update(Request $request, string $id): ProductoResource|JsonResponse
    {
        return parent::update($request, $id);
    }

    #[OA\Delete(
        path: '/api/v1/productos/{id}',
        tags: ['Productos'],
        security: [['bearerAuth' => []]],
        summary: 'Eliminar un producto',
        responses: [
            new OA\Response(response: 204, description: 'Producto eliminado'),
            new OA\Response(response: 404, description: 'Producto no encontrado'),
        ]
    )]
    public function destroy(string $id): JsonResponse
    {
        return parent::destroy($id);
    }
}
