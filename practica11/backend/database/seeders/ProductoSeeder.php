<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Camara Mirrorless', 'descripcion' => 'Equipo compacto para fotografia y video con gran calidad de imagen.', 'precio' => 15499.00, 'stock' => 6],
            ['nombre' => 'Smartwatch Pro', 'descripcion' => 'Reloj inteligente con monitoreo de salud y GPS integrado.', 'precio' => 3999.00, 'stock' => 20],
            ['nombre' => 'Tablet 11 pulgadas', 'descripcion' => 'Pantalla amplia, 128 GB y conexion WiFi para estudio o trabajo.', 'precio' => 7299.90, 'stock' => 14],
            ['nombre' => 'Power Bank 20000mAh', 'descripcion' => 'Bateria portatil con carga rapida USB-C.', 'precio' => 849.00, 'stock' => 50],
            ['nombre' => 'Bocina Bluetooth', 'descripcion' => 'Sonido potente y diseno resistente para uso diario.', 'precio' => 1299.00, 'stock' => 30],
            ['nombre' => 'Hub USB-C', 'descripcion' => 'Amplia los puertos de tu laptop con conexiones practicas.', 'precio' => 999.00, 'stock' => 28],
            ['nombre' => 'Microfono USB', 'descripcion' => 'Ideal para clases, podcasts y transmisiones en vivo.', 'precio' => 1890.00, 'stock' => 11],
            ['nombre' => 'SSD externo 2TB', 'descripcion' => 'Almacenamiento veloz para respaldos y archivos pesados.', 'precio' => 3890.00, 'stock' => 9],
            ['nombre' => 'Mouse Ergonomico', 'descripcion' => 'Diseno vertical comodo para jornadas largas de oficina.', 'precio' => 649.00, 'stock' => 35],
            ['nombre' => 'Teclado Mecanico', 'descripcion' => 'Respuesta precisa, retroiluminacion RGB y switches rojos.', 'precio' => 1799.00, 'stock' => 18],
            ['nombre' => 'Monitor 27 pulgadas', 'descripcion' => 'Pantalla QHD de 165 Hz para trabajo, diseno o juegos.', 'precio' => 6899.00, 'stock' => 12],
            ['nombre' => 'Laptop Ryzen 7', 'descripcion' => 'Equipo equilibrado con 16 GB de RAM y SSD de 512 GB.', 'precio' => 22999.00, 'stock' => 7],
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
