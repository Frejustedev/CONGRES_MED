<?php

use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portail public
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');

/*
|--------------------------------------------------------------------------
| Espace authentifie (Fortify + Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
