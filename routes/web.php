<?php

use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', function () {
        return view('perfil', ['user' => auth()->user()]);
    })->name('perfil');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])
        ->name('attachments.destroy');
});

Route::middleware(['auth', 'verified', 'verificar.rol:admin'])->prefix('admin')->name('admin.demo.')->group(function () {
    Route::get('/panel', function () {
        return view('admin.panel');
    })->name('panel');
});

Route::middleware(['auth', 'verified', 'verificar.rol:editor'])->prefix('editor')->name('editor.demo.')->group(function () {
    Route::get('/articulos', function () {
        return view('editor.articulos');
    })->name('articulos');
});

Route::view('/movil', 'movil')->name('movil');

Route::middleware(['registrar.peticion', 'solo.celular'])->prefix('celular')->name('celular.')->group(function () {
    Route::get('/noticias', function () {
        return view('practica4.celular', [
            'titulo' => 'Noticias para celular',
            'descripcion' => 'Esta ruta demuestra la redirección automática cuando el User-Agent pertenece a un teléfono.',
        ]);
    })->name('noticias');

    Route::get('/servicios', function () {
        return view('practica4.celular', [
            'titulo' => 'Servicios para celular',
            'descripcion' => 'El middleware permite el acceso en escritorio y redirige a /movil desde dispositivos móviles.',
        ]);
    })->name('servicios');

    Route::get('/galeria', function () {
        return view('practica4.celular', [
            'titulo' => 'Galería para celular',
            'descripcion' => 'Se aplicó SoloCelular en tres rutas distintas, como pide la práctica.',
        ]);
    })->name('galeria');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:admin')
        ->name('dashboard');

    Route::resource('/posts', PostAdminController::class)
        ->middleware('role:admin,editor');

    Route::resource('/audits', AuditController::class)
        ->only(['index', 'show'])
        ->middleware('role:admin');
});
