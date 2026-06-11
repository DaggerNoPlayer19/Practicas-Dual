<?php

use App\Http\Controllers\Api\V1\AuthController as V1AuthController;
use App\Http\Controllers\Api\V1\PedidoController as V1PedidoController;
use App\Http\Controllers\Api\V1\ProductoController as V1ProductoController;
use App\Http\Controllers\Api\V2\ProductoController as V2ProductoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('/register', [V1AuthController::class, 'register']);
    Route::post('/login', [V1AuthController::class, 'login']);
    Route::get('/productos', [V1ProductoController::class, 'index']);
    Route::get('/productos/{id}', [V1ProductoController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('/logout', [V1AuthController::class, 'logout']);
        Route::get('/me', [V1AuthController::class, 'me']);
        Route::post('/pedidos', [V1PedidoController::class, 'store']);
        Route::get('/pedidos/{pedido}', [V1PedidoController::class, 'show']);
    });

    Route::middleware(['auth:sanctum', 'admin'])->group(function (): void {
        Route::post('/productos', [V1ProductoController::class, 'store']);
        Route::put('/productos/{id}', [V1ProductoController::class, 'update']);
        Route::delete('/productos/{id}', [V1ProductoController::class, 'destroy']);
    });
});

Route::prefix('v2')->group(function (): void {
    Route::get('/productos', [V2ProductoController::class, 'index']);
    Route::get('/productos/{id}', [V2ProductoController::class, 'show']);

    Route::middleware(['auth:sanctum', 'admin'])->group(function (): void {
        Route::post('/productos', [V2ProductoController::class, 'store']);
        Route::put('/productos/{id}', [V2ProductoController::class, 'update']);
        Route::delete('/productos/{id}', [V2ProductoController::class, 'destroy']);
    });
});
