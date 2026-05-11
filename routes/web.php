<?php

use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ExhibitorsController;
use App\Http\Controllers\Public\FaqController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InfosController;
use App\Http\Controllers\Public\ProgrammeController;
use App\Http\Controllers\Public\ParticipantDownloadController;
use App\Http\Controllers\Public\PaymentController;
use App\Http\Controllers\Public\RegistrationController;
use App\Http\Controllers\Webhooks\PaymentWebhookController;
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

// Paiements
Route::get('/inscription/{reference}/payment', [PaymentController::class, 'method'])->name('payment.method');
Route::post('/inscription/{reference}/payment', [PaymentController::class, 'initiate'])
    ->middleware('throttle:10,1')
    ->name('payment.initiate');
Route::get('/inscription/{reference}/payment/cash', [PaymentController::class, 'cashInstructions'])
    ->name('payment.cash-instructions');
Route::get('/inscription/{reference}/payment/return', [PaymentController::class, 'return'])
    ->name('payment.return');
Route::get('/inscription/{reference}/payment/cancel', [PaymentController::class, 'cancel'])
    ->name('payment.cancel');

// Téléchargements participant (signed URL ou email match en query string)
Route::get('/mon-inscription/{reference}/{type}', ParticipantDownloadController::class)
    ->where('type', 'badge|invoice')
    ->name('participant.download');

// Webhooks (CSRF exempté via VerifyCsrfToken middleware)
Route::post('/webhooks/payments/kkiapay', [PaymentWebhookController::class, 'kkiapay'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
    ->name('webhooks.kkiapay');
Route::post('/webhooks/payments/stripe', [PaymentWebhookController::class, 'stripe'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
    ->name('webhooks.stripe');

/*
|--------------------------------------------------------------------------
| Espace authentifié (Fortify + Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
