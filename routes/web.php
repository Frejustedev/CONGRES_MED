<?php

use App\Http\Controllers\Admin\AbstractManagementController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GroupRegistrationController;
use App\Http\Controllers\Admin\RegistrationManagementController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\VisaLetterController;
use App\Http\Controllers\Public\AbstractController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\LegalController;
use App\Http\Controllers\Public\ExhibitorsController;
use App\Http\Controllers\Public\FaqController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InfosController;
use App\Http\Controllers\Public\ParticipantDownloadController;
use App\Http\Controllers\Public\PaymentController;
use App\Http\Controllers\Public\ProgrammeController;
use App\Http\Controllers\Public\RegistrationController;
use App\Http\Controllers\Public\SpeakersController;
use App\Http\Controllers\Public\SponsorsController;
use App\Http\Controllers\Public\VerifyController;
use App\Http\Controllers\Reviewer\ReviewController;
use App\Http\Controllers\Staff\ScanController;
use App\Http\Controllers\Webhooks\PaymentWebhookController;
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

// Pages légales
Route::get('/cgv', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/confidentialite', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/mentions-legales', [LegalController::class, 'mentions'])->name('legal.mentions');

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

// Soumission de résumés (publique, sans compte requis)
Route::get('/abstracts/submit', [AbstractController::class, 'submitForm'])->name('abstracts.submit');
Route::post('/abstracts/submit', [AbstractController::class, 'submit'])
    ->middleware('throttle:5,1')
    ->name('abstracts.store');
Route::get('/abstracts/{reference}/submitted', [AbstractController::class, 'submitted'])->name('abstracts.submitted');
Route::get('/abstracts/lookup', [AbstractController::class, 'lookup'])->name('abstracts.lookup');
Route::post('/abstracts/lookup', [AbstractController::class, 'lookupSubmit'])
    ->middleware('throttle:10,1')
    ->name('abstracts.lookup.submit');

// Espace reviewer (auth + role)
Route::middleware(['auth', 'verified', 'role:reviewer|admin-scientifique|super-admin'])->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('/', [ReviewController::class, 'dashboard'])->name('dashboard');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('review.show');
    Route::post('/reviews/{review}', [ReviewController::class, 'submit'])->name('review.submit');
});

// Espace staff Jour J (regisseur + admin-orga + super-admin)
Route::middleware(['auth', 'verified', 'role:regisseur|admin-orga|super-admin'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/scan', [ScanController::class, 'show'])->name('scan');
    Route::post('/scan/validate', [ScanController::class, 'validateScan'])
        ->middleware('throttle:120,1')
        ->name('scan.validate');
});

// Vérification publique d'attestation par code
Route::get('/verify/{code}', VerifyController::class)->name('attestation.verify');

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

/*
|--------------------------------------------------------------------------
| Admin back-office (admin-orga + super-admin + tresorier selon sections)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin-orga|admin-scientifique|tresorier|super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');

    // Inscriptions
    Route::get('/registrations', [RegistrationManagementController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/export', [RegistrationManagementController::class, 'exportCsv'])->name('registrations.export');
    Route::post('/registrations/{id}/badge', [RegistrationManagementController::class, 'regenerateBadge'])->name('registrations.badge');
    Route::post('/registrations/{id}/invoice', [RegistrationManagementController::class, 'regenerateInvoice'])->name('registrations.invoice');
    Route::post('/registrations/{id}/cancel', [RegistrationManagementController::class, 'cancel'])->name('registrations.cancel');

    // Abstracts
    Route::get('/abstracts', [AbstractManagementController::class, 'index'])->name('abstracts.index');
    Route::get('/abstracts/{id}', [AbstractManagementController::class, 'show'])->name('abstracts.show');
    Route::post('/abstracts/{id}/assign-reviewer', [AbstractManagementController::class, 'assignReviewer'])->name('abstracts.assign');
    Route::post('/abstracts/{id}/decide', [AbstractManagementController::class, 'decide'])->name('abstracts.decide');

    // Content management (sponsors, exhibitors, speakers, sessions, symposiums, rooms)
    Route::get('/content/{type}', [AdminContentController::class, 'index'])->where('type', 'sponsors|exhibitors|speakers|sessions|symposiums|rooms')->name('content.index');
    Route::post('/content/{type}', [AdminContentController::class, 'store'])->where('type', 'sponsors|exhibitors|speakers|sessions|symposiums|rooms')->name('content.store');
    Route::put('/content/{type}/{id}', [AdminContentController::class, 'update'])->where('type', 'sponsors|exhibitors|speakers|sessions|symposiums|rooms')->name('content.update');
    Route::delete('/content/{type}/{id}', [AdminContentController::class, 'destroy'])->where('type', 'sponsors|exhibitors|speakers|sessions|symposiums|rooms')->name('content.destroy');

    // Groupes (inscriptions groupées institutions)
    Route::get('/groups', [GroupRegistrationController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupRegistrationController::class, 'store'])->name('groups.store');

    // Visa letters
    Route::get('/visa-letters', [VisaLetterController::class, 'index'])->name('visa.index');
    Route::post('/visa-letters/{id}/generate', [VisaLetterController::class, 'generate'])->name('visa.generate');

    // Settings (configuration globale du congrès depuis l'admin)
    Route::get('/settings/event', [AdminSettingsController::class, 'event'])->name('settings.event');
    Route::put('/settings/event', [AdminSettingsController::class, 'updateEvent'])->name('settings.event.update');
    Route::get('/settings/branding', [AdminSettingsController::class, 'branding'])->name('settings.branding');
    Route::put('/settings/branding', [AdminSettingsController::class, 'updateBranding'])->name('settings.branding.update');
    Route::get('/settings/modules', [AdminSettingsController::class, 'modules'])->name('settings.modules');
    Route::put('/settings/modules', [AdminSettingsController::class, 'updateModules'])->name('settings.modules.update');
    Route::get('/settings/payment', [AdminSettingsController::class, 'payment'])->name('settings.payment');
    Route::put('/settings/payment', [AdminSettingsController::class, 'updatePayment'])->name('settings.payment.update');
    Route::get('/settings/mail', [AdminSettingsController::class, 'mail'])->name('settings.mail');
    Route::put('/settings/mail', [AdminSettingsController::class, 'updateMail'])->name('settings.mail.update');
});

require __DIR__.'/settings.php';
