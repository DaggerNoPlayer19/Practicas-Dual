<?php

use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('categorias', CategoriaController::class);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::apiResource('productos', ProductoController::class);
});
