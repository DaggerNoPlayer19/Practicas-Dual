<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriaResource;
use App\Http\Resources\ProductoResource;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        return CategoriaResource::collection(
            Categoria::with('productos')->orderBy('nombre')->get()
        );
    }

    public function store(Request $request): CategoriaResource
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:categorias,nombre'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $data['slug'] = Str::slug($data['nombre']);

        return new CategoriaResource(Categoria::create($data));
    }

    public function show(string $id): CategoriaResource|JsonResponse
    {
        $categoria = Categoria::with('productos')->find($id);

        if (! $categoria) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }

        return new CategoriaResource($categoria);
    }

    public function update(Request $request, string $id): CategoriaResource|JsonResponse
    {
        $categoria = Categoria::find($id);

        if (! $categoria) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
        ]);

        if ($data['nombre'] !== $categoria->nombre) {
            $categoria->slug = Str::slug($data['nombre']);
        }

        $categoria->fill($data);
        $categoria->save();

        return new CategoriaResource($categoria->refresh());
    }

    public function destroy(string $id): JsonResponse
    {
        $categoria = Categoria::find($id);

        if (! $categoria) {
            return response()->json(['message' => 'Categoria no encontrada'], 404);
        }

        $categoria->delete();

        return response()->json([], 204);
    }

    public function productos(Categoria $categoria)
    {
        return ProductoResource::collection(
            $categoria->productos()->with('categoria')->orderByDesc('id')->get()
        );
    }
}
