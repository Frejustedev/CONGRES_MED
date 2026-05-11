<?php

use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ExhibitorsController;
use App\Http\Controllers\Public\FaqController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InfosController;
use App\Http\Controllers\Public\ProgrammeController;
use App\Http\Controllers\Public\RegistrationController;
use App\Http\Controllers\Public\SpeakersController;
use App\Http\Controllers\Public\SponsorsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Portail public
|--------------------------------------------------------------------------
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/programme', ProgrammeController::class)->name('programme.index');
Route::get('/intervenants', SpeakersController::class)->name('speakers.index');
Route::get('/sponsors', SponsorsController::class)->name('sponsors.index');
Route::get('/exposants', ExhibitorsController::class)->name('exhibitors.index');
Route::get('/infos-pratiques', InfosController::class)->name('infos.index');
Route::get('/faq', FaqController::class)->name('faq.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

// Inscriptions congres (wizard public)
Route::get('/inscription', [RegistrationController::class, 'index'])->name('registration.index');
Route::post('/inscription/promo-check', [RegistrationController::class, 'checkPromo'])
    ->middleware('throttle:30,1')
    ->name('registration.promo-check');
Route::post('/inscription', [RegistrationController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('registration.store');
Route::get('/inscription/{reference}/confirmation', [RegistrationController::class, 'confirmation'])
    ->name('registration.confirmation');

/*
|--------------------------------------------------------------------------
| Espace authentifié (Fortify + Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
