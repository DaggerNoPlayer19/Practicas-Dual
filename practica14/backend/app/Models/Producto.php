<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;

    protected $with = ['categoria'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'imagen',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function scopeBuscar($query, ?string $termino)
    {
        return $query->when($termino, function ($q, $termino) {
            $q->where(function ($subquery) use ($termino) {
                $subquery->where('nombre', 'like', '%'.$termino.'%')
                    ->orWhere('descripcion', 'like', '%'.$termino.'%');
            });
        });
    }

    public function scopeDeCategoria($query, ?string $categoriaId)
    {
        return $query->when($categoriaId, fn ($q) => $q->where('categoria_id', $categoriaId));
    }

    public function scopeRangoPrecio($query, ?string $min, ?string $max)
    {
        return $query
            ->when($min !== null && $min !== '', fn ($q) => $q->where('precio', '>=', $min))
            ->when($max !== null && $max !== '', fn ($q) => $q->where('precio', '<=', $max));
    }
}
