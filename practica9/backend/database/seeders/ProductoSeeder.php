<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Camara Mirrorless', 'descripcion' => '24MP con lente 18-55mm', 'precio' => 15499.00, 'stock' => 6],
            ['nombre' => 'Smartwatch Pro', 'descripcion' => 'Monitoreo de salud y GPS', 'precio' => 3999.00, 'stock' => 20],
            ['nombre' => 'Tablet 11 pulgadas', 'descripcion' => '128GB, WiFi', 'precio' => 7299.90, 'stock' => 14],
            ['nombre' => 'Power Bank 20000mAh', 'descripcion' => 'Carga rapida USB-C', 'precio' => 849.00, 'stock' => 50],
            ['nombre' => 'Bocina Bluetooth', 'descripcion' => 'Resistente al agua IPX7', 'precio' => 1299.00, 'stock' => 30],
            ['nombre' => 'Hub USB-C', 'descripcion' => '7 puertos para laptop', 'precio' => 999.00, 'stock' => 28],
            ['nombre' => 'Microfono USB', 'descripcion' => 'Condensador para streaming', 'precio' => 1890.00, 'stock' => 11],
            ['nombre' => 'SSD externo 2TB', 'descripcion' => 'Lectura hasta 1050MB/s', 'precio' => 3890.00, 'stock' => 9],
            ['nombre' => 'Mouse Ergonomico', 'descripcion' => 'Diseno vertical para oficina', 'precio' => 649.00, 'stock' => 35],
            ['nombre' => 'Teclado Mecanico', 'descripcion' => 'Switches rojos RGB', 'precio' => 1799.00, 'stock' => 18],
            ['nombre' => 'Monitor 27 pulgadas', 'descripcion' => 'QHD 165Hz', 'precio' => 6899.00, 'stock' => 12],
            ['nombre' => 'Laptop Ryzen 7', 'descripcion' => '16GB RAM, 512GB SSD', 'precio' => 22999.00, 'stock' => 7],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
