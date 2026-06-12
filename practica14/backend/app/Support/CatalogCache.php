<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class CatalogCache
{
    private const VERSION_KEY = 'catalogo.cache.version';

    public static function version(): int
    {
        return (int) Cache::rememberForever(self::VERSION_KEY, fn () => 1);
    }

    public static function bump(): int
    {
        $next = self::version() + 1;

        Cache::forever(self::VERSION_KEY, $next);

        return $next;
    }

    public static function categoriasKey(): string
    {
        return 'catalogo.categorias.v'.self::version();
    }

    public static function productosKey(array $filters): string
    {
        return 'catalogo.productos.v'.self::version().'.'.md5(json_encode($filters));
    }
}
