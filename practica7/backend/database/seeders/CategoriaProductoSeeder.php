<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaProductoSeeder extends Seeder
{
    public function run(): void
    {
        $categoriasBase = [
            'Electronica',
            'Ropa',
            'Hogar',
            'Deportes',
        ];

        foreach ($categoriasBase as $nombre) {
            $categoria = Categoria::create([
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
                'descripcion' => 'Categoria de prueba para la practica 7.',
            ]);

            Producto::factory()->count(15)->create([
                'categoria_id' => $categoria->id,
            ]);
        }
    }
}
