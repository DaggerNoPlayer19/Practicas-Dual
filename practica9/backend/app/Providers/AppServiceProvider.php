<?php

namespace App\Providers;

use App\Models\Producto;
use App\Policies\ProductoPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Producto::class, ProductoPolicy::class);

        Gate::define('crear-producto', function ($user) {
            return in_array($user->rol, ['admin', 'editor'], true);
        });

        Gate::define('editar-producto', function ($user) {
            return in_array($user->rol, ['admin', 'editor'], true);
        });

        Gate::define('eliminar-producto', function ($user) {
            return $user->rol === 'admin';
        });
    }
}
