<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
            ->with('categoria')
            ->buscar($request->query('busqueda'))
            ->deCategoria($request->query('categoria'))
            ->rangoPrecio($request->query('min'), $request->query('max'))
            ->orderBy($orderBy, $dir);

        return ProductoResource::collection($query->paginate($perPage, ['*'], 'pagina', $pagina));
    }

    public function store(StoreProductoRequest $request): ProductoResource
    {
        $this->authorize('create', Producto::class);

        $data = $request->validated();

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        return new ProductoResource(Producto::create($data)->load('categoria'));
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

        return new ProductoResource($producto->refresh()->load('categoria'));
    }

    public function destroy(string $id): JsonResponse
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

        return response()->noContent();
    }
}
