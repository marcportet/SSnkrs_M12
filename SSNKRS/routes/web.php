<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::view('/{any?}','home')
    ->where('any','.*');
/*
Route::get('/', function () {
    return view('home');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/