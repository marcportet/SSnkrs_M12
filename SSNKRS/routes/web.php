<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SneakersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/catalogo/{marca?}', [SneakersController::class, 'catalogo'])->name('catalogo');
Route::get('/detalle/{id}', [SneakersController::class, 'detalle'])->name('detalle');
Route::get('/contacto', [SneakersController::class, 'contacto'])->name('contacto');

require __DIR__.'/auth.php';
