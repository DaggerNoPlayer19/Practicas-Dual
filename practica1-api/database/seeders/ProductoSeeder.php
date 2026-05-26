<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Laptop Lenovo', 'descripcion' => 'Laptop Ryzen 7 con 16GB RAM', 'precio' => 18500.00, 'stock' => 12],
            ['nombre' => 'Mouse Logitech', 'descripcion' => 'Mouse inalámbrico ergonómico', 'precio' => 499.90, 'stock' => 40],
            ['nombre' => 'Teclado Mecánico', 'descripcion' => 'Switches azules con retroiluminación', 'precio' => 1299.00, 'stock' => 25],
            ['nombre' => 'Monitor 24 pulgadas', 'descripcion' => 'Panel IPS Full HD', 'precio' => 3299.99, 'stock' => 18],
            ['nombre' => 'Disco SSD 1TB', 'descripcion' => 'NVMe Gen4 alta velocidad', 'precio' => 1799.00, 'stock' => 30],
            ['nombre' => 'Audífonos Bluetooth', 'descripcion' => 'Cancelación de ruido activa', 'precio' => 2199.00, 'stock' => 22],
            ['nombre' => 'Webcam HD', 'descripcion' => 'Resolución 1080p con micrófono', 'precio' => 899.50, 'stock' => 35],
            ['nombre' => 'Silla Gamer', 'descripcion' => 'Soporte lumbar ajustable', 'precio' => 4599.00, 'stock' => 10],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
