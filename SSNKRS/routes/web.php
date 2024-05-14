<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SneakersController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return Inertia::render('home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback', function () {

    // Si el correo que se intenta inicar con google ya esta registrado
    // inicia session con el correo de esa cuenta.
    $userGoogle = Socialite::driver('google')->user();

    $existingUser = User::where('email', $userGoogle->email)->first();

    if ($existingUser) {
        Auth::login($existingUser);
        return redirect('/');
    }

    //Login con google
    $user_google = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'google_id' => $user_google->id,
    ], [
        'name' => $user_google->name,
        'email' => $user_google->email,
    ]);

    Auth::login($user);

    return redirect('/');
    // $user->token
});

/**
Route::get('/', function () {
    return Inertia::render('home');
})->middleware(['auth', 'verified'])->name('dashboard');
 */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/google_destroy', [ProfileController::class, 'google_destroy'])->name('profile.google_destroy');
});

Route::get('/catalogo/{marca?}', [SneakersController::class, 'catalogo'])->name('catalogo');
Route::get('/detalle/{id}', [SneakersController::class, 'detalle'])->name('detalle');
Route::get('/contacto', [SneakersController::class, 'contacto'])->name('contacto');
Route::get('/stock', [SneakersController::class, 'stock'])->name('stock');
Route::get('/usuarios', [SneakersController::class, 'usuarios'])->name('usuarios');

Route::get('/carrito/{id_carrito}', [SneakersController::class, 'carrito'])->name('carrito.show');
Route::put('/carrito/{id_producto}/{id_cliente}/{size}', [SneakersController::class, 'carrito_add'])->name('carrito.add');


Route::get('/fqs', [SneakersController::class, 'fqs'])->name('fqs');

Route::get('/equipo', function () {
    return Inertia::render('Views/equipo');
})->name('equipo');

require __DIR__ . '/auth.php';

Route::post('/contacto', ContactController::class)->name('contact');
