<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        $nombres = [
            'Laptop Ultrabook',
            'Monitor LED',
            'Teclado Inalambrico',
            'Mouse Ergonomico',
            'Tablet Android',
            'Audifonos Bluetooth',
            'Bocina Portatil',
            'Camara Digital',
            'Cargador Rapido',
            'Disco SSD',
            'Sillon Modular',
            'Lampara LED',
            'Juego de Sartenes',
            'Organizador de Cocina',
            'Mancuernas Ajustables',
            'Tenis Deportivos',
            'Playera Deportiva',
            'Termo Acero',
            'Cuerda para Saltar',
            'Mochila Urbana',
        ];

        return [
            'nombre' => fake()->unique()->randomElement($nombres),
            'descripcion' => fake()->sentence(6),
            'precio' => fake()->randomFloat(2, 199, 24999),
            'stock' => fake()->numberBetween(1, 80),
            'imagen' => null,
            'categoria_id' => null,
        ];
    }
}
