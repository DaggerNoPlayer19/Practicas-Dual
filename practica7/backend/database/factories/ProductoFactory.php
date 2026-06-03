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
        return [
            'nombre' => fake()->unique()->words(3, true),
            'descripcion' => fake()->sentence(10),
            'precio' => fake()->randomFloat(2, 99, 29999),
            'stock' => fake()->numberBetween(1, 80),
            'imagen' => null,
            'categoria_id' => null,
        ];
    }
}
