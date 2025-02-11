<?php

use Illuminate\Support\Facades\Route;

$routes = function() {
    Route::get('/',\App\Http\Controllers\HomeController::class)->name('home');

    Route::get('/orders', \App\Http\Controllers\OrdersController::class)
        ->middleware(['auth'])
        ->name('orders');
};


// routes '/en'
Route::middleware('language')->group($routes);

Route::middleware('language')
    ->prefix('{locale?}')->whereIn('locale', array_keys(config('app.available_locales')))
    ->group($routes);


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
