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
        $catalogo = [
            'Electronica' => [
                ['nombre' => 'Laptop Ultrabook', 'descripcion' => 'Equipo ligero para trabajo y estudio', 'precio' => 18999.00, 'stock' => 8],
                ['nombre' => 'Monitor 27 pulgadas', 'descripcion' => 'Pantalla QHD con tasa de refresco alta', 'precio' => 6999.00, 'stock' => 12],
                ['nombre' => 'Teclado Mecanico', 'descripcion' => 'Switches rojos y retroiluminacion RGB', 'precio' => 1799.00, 'stock' => 18],
                ['nombre' => 'Mouse Ergonomico', 'descripcion' => 'Diseno vertical para mayor comodidad', 'precio' => 649.00, 'stock' => 35],
                ['nombre' => 'Audifonos Bluetooth', 'descripcion' => 'Cancelacion de ruido y bateria de larga duracion', 'precio' => 1299.00, 'stock' => 24],
                ['nombre' => 'Tablet 11 pulgadas', 'descripcion' => 'Memoria amplia y conectividad WiFi', 'precio' => 7299.90, 'stock' => 14],
                ['nombre' => 'Camara Digital', 'descripcion' => 'Resolucion alta para fotografia diaria', 'precio' => 15499.00, 'stock' => 6],
                ['nombre' => 'Cargador Rapido', 'descripcion' => 'Cargador USB-C con carga eficiente', 'precio' => 399.00, 'stock' => 40],
                ['nombre' => 'Disco SSD 1TB', 'descripcion' => 'Almacenamiento veloz para laptop', 'precio' => 2890.00, 'stock' => 10],
                ['nombre' => 'Bocina Portatil', 'descripcion' => 'Sonido potente y resistencia al agua', 'precio' => 1199.00, 'stock' => 20],
                ['nombre' => 'Hub USB-C', 'descripcion' => 'Expande puertos para trabajo remoto', 'precio' => 999.00, 'stock' => 28],
                ['nombre' => 'Microfono USB', 'descripcion' => 'Ideal para clases y streaming', 'precio' => 1890.00, 'stock' => 11],
                ['nombre' => 'Smartwatch Pro', 'descripcion' => 'Monitoreo de salud y GPS', 'precio' => 3999.00, 'stock' => 20],
                ['nombre' => 'Power Bank 20000mAh', 'descripcion' => 'Carga rapida para dispositivos moviles', 'precio' => 849.00, 'stock' => 50],
                ['nombre' => 'Consola Portatil', 'descripcion' => 'Entretenimiento para viajes y descanso', 'precio' => 5499.00, 'stock' => 7],
            ],
            'Ropa' => [
                ['nombre' => 'Sudadera Deportiva', 'descripcion' => 'Tela suave y corte comodo', 'precio' => 899.00, 'stock' => 22],
                ['nombre' => 'Playera Basica', 'descripcion' => 'Algodon de alta durabilidad', 'precio' => 249.00, 'stock' => 60],
                ['nombre' => 'Pantalon Jeans', 'descripcion' => 'Mezclilla elastica y resistente', 'precio' => 899.00, 'stock' => 26],
                ['nombre' => 'Tenis Deportivos', 'descripcion' => 'Suela ligera para caminata o entrenamiento', 'precio' => 1399.00, 'stock' => 20],
                ['nombre' => 'Mochila Urbana', 'descripcion' => 'Compartimento para laptop y accesorios', 'precio' => 799.00, 'stock' => 30],
                ['nombre' => 'Gorra Ajustable', 'descripcion' => 'Visera curva y cierre regulable', 'precio' => 199.00, 'stock' => 45],
                ['nombre' => 'Chamarra Ligera', 'descripcion' => 'Proteccion contra frio moderado', 'precio' => 1299.00, 'stock' => 16],
                ['nombre' => 'Calcetas Deportivas', 'descripcion' => 'Pack para entrenamiento diario', 'precio' => 179.00, 'stock' => 70],
                ['nombre' => 'Pijama Corta', 'descripcion' => 'Suave al tacto para descanso', 'precio' => 449.00, 'stock' => 18],
                ['nombre' => 'Vestido Casual', 'descripcion' => 'Diseno sencillo para uso diario', 'precio' => 699.00, 'stock' => 14],
                ['nombre' => 'Blusa Formal', 'descripcion' => 'Ideal para oficina y reuniones', 'precio' => 579.00, 'stock' => 24],
                ['nombre' => 'Pantalon Deportivo', 'descripcion' => 'Comodidad para actividad fisica', 'precio' => 649.00, 'stock' => 28],
                ['nombre' => 'Sudadera Ligera', 'descripcion' => 'Para clima templado', 'precio' => 799.00, 'stock' => 19],
                ['nombre' => 'Traje de Bano', 'descripcion' => 'Secado rapido para alberca', 'precio' => 529.00, 'stock' => 21],
                ['nombre' => 'Bufanda Tejida', 'descripcion' => 'Accesorio para temporada de frio', 'precio' => 299.00, 'stock' => 12],
            ],
            'Hogar' => [
                ['nombre' => 'Juego de Sartenes', 'descripcion' => 'Set antiadherente de cocina', 'precio' => 1299.00, 'stock' => 22],
                ['nombre' => 'Lampara LED', 'descripcion' => 'Luz regulable con puerto USB', 'precio' => 599.00, 'stock' => 35],
                ['nombre' => 'Organizador de Cocina', 'descripcion' => 'Accesorios para despensa y gabinete', 'precio' => 349.00, 'stock' => 40],
                ['nombre' => 'Cama Individual', 'descripcion' => 'Estructura de madera reforzada', 'precio' => 5499.00, 'stock' => 6],
                ['nombre' => 'Cuerda para Saltar', 'descripcion' => 'Cable de acero con mangos ergonomicos', 'precio' => 199.00, 'stock' => 45],
                ['nombre' => 'Sofa Modular', 'descripcion' => 'Tres plazas con tapizado gris', 'precio' => 8999.00, 'stock' => 4],
                ['nombre' => 'Termo Deportivo', 'descripcion' => 'Acero inoxidable y tapa hermetica', 'precio' => 289.00, 'stock' => 38],
                ['nombre' => 'Almohada Ortopedica', 'descripcion' => 'Soporte para descanso y postura', 'precio' => 699.00, 'stock' => 25],
                ['nombre' => 'Mesa Auxiliar', 'descripcion' => 'Superficie compacta para sala', 'precio' => 1099.00, 'stock' => 11],
                ['nombre' => 'Juego de Vajilla', 'descripcion' => 'Platos y tazas para seis personas', 'precio' => 1499.00, 'stock' => 13],
                ['nombre' => 'Escoba y Recogedor', 'descripcion' => 'Kit basico de limpieza', 'precio' => 169.00, 'stock' => 55],
                ['nombre' => 'Cortina Decorativa', 'descripcion' => 'Tela ligera para interior', 'precio' => 499.00, 'stock' => 27],
                ['nombre' => 'Caja Organizadora', 'descripcion' => 'Orden para closet o estante', 'precio' => 249.00, 'stock' => 31],
                ['nombre' => 'Juego de Toallas', 'descripcion' => 'Algodon suave para el bano', 'precio' => 899.00, 'stock' => 17],
                ['nombre' => 'Maceta Decorativa', 'descripcion' => 'Diseno minimalista para interiores', 'precio' => 329.00, 'stock' => 22],
            ],
            'Deportes' => [
                ['nombre' => 'Balon de Futbol', 'descripcion' => 'Talla oficial para entrenamiento', 'precio' => 499.00, 'stock' => 50],
                ['nombre' => 'Mancuernas Ajustables', 'descripcion' => 'Par de 10 a 20 kg', 'precio' => 2999.00, 'stock' => 12],
                ['nombre' => 'Tenis Running', 'descripcion' => 'Suela ligera para entrenamiento', 'precio' => 1399.00, 'stock' => 20],
                ['nombre' => 'Cuerda para Saltar', 'descripcion' => 'Ideal para cardio y condicion fisica', 'precio' => 199.00, 'stock' => 45],
                ['nombre' => 'Termo Deportivo', 'descripcion' => 'Botella aislante para agua fria o caliente', 'precio' => 289.00, 'stock' => 38],
                ['nombre' => 'Bicicleta Estatica', 'descripcion' => 'Entrenamiento en casa con resistencia', 'precio' => 5499.00, 'stock' => 5],
                ['nombre' => 'Colchoneta Yoga', 'descripcion' => 'Acolchado antideslizante', 'precio' => 599.00, 'stock' => 30],
                ['nombre' => 'Guantes de Box', 'descripcion' => 'Proteccion para entrenamientos de contacto', 'precio' => 799.00, 'stock' => 16],
                ['nombre' => 'Casco Deportivo', 'descripcion' => 'Seguridad para ciclismo o patinaje', 'precio' => 899.00, 'stock' => 14],
                ['nombre' => 'Cronometro Digital', 'descripcion' => 'Control de tiempo para rutinas', 'precio' => 349.00, 'stock' => 25],
                ['nombre' => 'Banda Elastica', 'descripcion' => 'Resistencia media para ejercicios', 'precio' => 179.00, 'stock' => 70],
                ['nombre' => 'Baston Trekking', 'descripcion' => 'Apoyo para senderismo', 'precio' => 649.00, 'stock' => 19],
                ['nombre' => 'Botella Hidratacion', 'descripcion' => 'Accesorio para entrenamiento diario', 'precio' => 249.00, 'stock' => 60],
                ['nombre' => 'Reloj Deportivo', 'descripcion' => 'Monitoreo de actividad fisica', 'precio' => 2199.00, 'stock' => 9],
                ['nombre' => 'Set de Conos', 'descripcion' => 'Practica de velocidad y agilidad', 'precio' => 299.00, 'stock' => 34],
            ],
        ];

        foreach ($catalogo as $nombreCategoria => $productos) {
            $categoria = Categoria::create([
                'nombre' => $nombreCategoria,
                'slug' => Str::slug($nombreCategoria),
                'descripcion' => 'Categoria de prueba para la practica 7.',
            ]);

            foreach ($productos as $producto) {
                Producto::create($producto + ['categoria_id' => $categoria->id]);
            }
        }
    }
}
