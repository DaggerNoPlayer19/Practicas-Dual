<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriaResource;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        return CategoriaResource::collection(
            Categoria::orderBy('nombre')->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150', 'unique:categorias,nombre'],
        ]);

        $categoria = Categoria::create([
            'nombre' => $data['nombre'],
            'slug' => Str::slug($data['nombre']),
        ]);

        return (new CategoriaResource($categoria))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Categoria $categoria): CategoriaResource
    {
        return new CategoriaResource($categoria);
    }

    public function update(Request $request, Categoria $categoria): CategoriaResource|JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:150', 'unique:categorias,nombre,' . $categoria->id],
        ]);

        $categoria->update([
            'nombre' => $data['nombre'],
            'slug' => Str::slug($data['nombre']),
        ]);

        return new CategoriaResource($categoria->refresh());
    }

    public function destroy(Categoria $categoria): JsonResponse
    {
        $categoria->delete();

        return response()->json([
            'message' => 'Categoria eliminada correctamente',
        ], 200);
    }
}
