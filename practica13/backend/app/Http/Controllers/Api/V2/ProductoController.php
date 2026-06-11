<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\V1\ProductoController as BaseProductoController;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class ProductoController extends BaseProductoController
{
    #[OA\Get(
        path: '/api/v2/productos',
        tags: ['Productos'],
        summary: 'Listar productos con busqueda y paginacion',
        responses: [new OA\Response(response: 200, description: 'Listado de productos filtrado')]
    )]
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = max(1, min((int) $request->query('per_page', 15), 50));
        $query = Producto::query()->orderByDesc('id');

        if ($request->filled('q')) {
            $search = $request->string('q');
            $query->where(function ($builder) use ($search): void {
                $builder->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        return \App\Http\Resources\ProductoResource::collection($query->paginate($perPage));
    }
}
