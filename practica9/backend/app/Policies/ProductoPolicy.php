<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->esAdmin()) {
            return true;
        }

        return null;
    }

    public function create(User $user): bool
    {
        return $user->puedeCrearProductos();
    }

    public function update(User $user, Producto $producto): bool
    {
        return $user->puedeEditarProductos();
    }

    public function delete(User $user, Producto $producto): bool
    {
        return $user->puedeEliminarProductos();
    }
}
