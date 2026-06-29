<?php

use Illuminate\Support\Facades\Route;

$frontendDist = realpath(base_path('../frontend/dist')) ?: base_path('../frontend/dist');

$serveFrontendFile = function (string $relativePath) use ($frontendDist) {
    $path = rtrim($frontendDist, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.ltrim($relativePath, DIRECTORY_SEPARATOR);

    if (!is_file($path)) {
        abort(404);
    }

    return response()->file($path);
};

$serveSpaIndex = function () use ($frontendDist) {
    $indexPath = rtrim($frontendDist, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'index.html';

    if (!is_file($indexPath)) {
        abort(500, 'No se encontro el build del frontend. Ejecuta npm run build dentro de practica6/frontend.');
    }

    return response(file_get_contents($indexPath), 200)
        ->header('Content-Type', 'text/html; charset=UTF-8');
};

Route::get('/', $serveSpaIndex);
Route::get('/favicon.svg', fn () => $serveFrontendFile('favicon.svg'));
Route::get('/icons.svg', fn () => $serveFrontendFile('icons.svg'));
Route::get('/img/{path}', fn (string $path) => $serveFrontendFile('img/'.$path))
    ->where('path', '.*');
Route::get('/assets/{path}', fn (string $path) => $serveFrontendFile('assets/'.$path))
    ->where('path', '.*');
Route::get('/{any}', $serveSpaIndex)
    ->where('any', '^(?!api).*$');
