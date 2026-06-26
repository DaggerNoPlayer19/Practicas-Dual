<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Tecnología',
            'Hogar',
            'Oficina',
            'Deportes',
            'Moda',
            'Salud',
            'Juguetes',
            'Automotriz',
        ];

        foreach ($categorias as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
            ]);
        }
    }
}
