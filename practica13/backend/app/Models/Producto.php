<?php

namespace App\Models;

use OpenApi\Annotations as OA;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Producto",
 *     type="object",
 *     title="Producto",
 *     required={"nombre","precio","stock"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Laptop Ryzen 7"),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Equipo equilibrado con 16 GB de RAM y SSD de 512 GB."),
 *     @OA\Property(property="precio", type="number", format="float", example=22999.00),
 *     @OA\Property(property="stock", type="integer", example=7),
 *     @OA\Property(property="imagen", type="string", nullable=true, example="productos/laptop.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", nullable=true)
 * )
 */
class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'imagen',
    ];

    public function pedidos(): HasMany
    {
        return $this->hasMany(PedidoItem::class);
    }
}
