<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use App\Support\CatalogCache;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = max(1, min((int) $request->query('por_pagina', 15), 50));
        $pagina = max(1, (int) $request->query('pagina', 1));
        $orden = $request->get('orden', 'nombre');
        $dir = strtolower($request->get('dir', 'asc')) === 'desc' ? 'desc' : 'asc';
        $orderColumns = ['nombre', 'precio', 'stock', 'created_at'];
        $orderBy = in_array($orden, $orderColumns, true) ? $orden : 'nombre';

        $query = Producto::query()
            ->buscar($request->query('busqueda'))
            ->deCategoria($request->query('categoria'))
            ->rangoPrecio($request->query('min'), $request->query('max'))
            ->orderBy($orderBy, $dir);

        $cacheKey = CatalogCache::productosKey([
            'busqueda' => (string) $request->query('busqueda', ''),
            'categoria' => (string) $request->query('categoria', ''),
            'min' => (string) $request->query('min', ''),
            'max' => (string) $request->query('max', ''),
            'orden' => $orderBy,
            'dir' => $dir,
            'pagina' => $pagina,
            'por_pagina' => $perPage,
        ]);

        $productos = Cache::remember($cacheKey, now()->addMinutes(30), fn () => $query->paginate($perPage, ['*'], 'pagina', $pagina));

        return ProductoResource::collection($productos);
    }

    public function store(StoreProductoRequest $request): ProductoResource
    {
        $this->authorize('create', Producto::class);

        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create($data);
        \App\Support\CatalogCache::bump();

        return new ProductoResource($producto);
    }

    public function show(string $id): ProductoResource|JsonResponse
    {
        $producto = Producto::with('categoria')->find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return new ProductoResource($producto);
    }

    public function update(UpdateProductoRequest $request, string $id): ProductoResource|JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $this->authorize('update', $producto);

        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);
        \App\Support\CatalogCache::bump();

        return new ProductoResource($producto->refresh()->load('categoria'));
    }

    public function destroy(string $id): JsonResponse|Response
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $this->authorize('delete', $producto);

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();
        \App\Support\CatalogCache::bump();

        return response()->noContent();
    }
}
