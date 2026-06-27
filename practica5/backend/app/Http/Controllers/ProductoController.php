<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    private function tokenAllows(Request $request, string $ability): bool
    {
        $token = $request->user()?->currentAccessToken();

        if (!$token) {
            return false;
        }

        return $token->can($ability);
    }

    private function denyIfMissingAbility(Request $request, string $ability): ?JsonResponse
    {
        if ($this->tokenAllows($request, $ability)) {
            return null;
        }

        return response()->json([
            'message' => "Tu token no tiene el permiso '{$ability}' para esta accion.",
        ], 403);
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = max(1, min((int) $request->query('per_page', 10), 50));
        $query = Producto::query()->orderByDesc('id');

        if ($request->filled('q')) {
            $query->where('nombre', 'like', '%'.$request->string('q').'%');
        }

        return ProductoResource::collection($query->paginate($perPage));
    }

    public function store(Request $request): ProductoResource|JsonResponse
    {
        if ($response = $this->denyIfMissingAbility($request, 'crear')) {
            return $response;
        }

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        return new ProductoResource(Producto::create($data));
    }

    public function show(string $id): ProductoResource|JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return new ProductoResource($producto);
    }

    public function update(Request $request, string $id): ProductoResource|JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        if ($response = $this->denyIfMissingAbility($request, 'editar')) {
            return $response;
        }

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return new ProductoResource($producto->refresh());
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        if ($response = $this->denyIfMissingAbility($request, 'eliminar')) {
            return $response;
        }

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json([], 204);
    }
}
