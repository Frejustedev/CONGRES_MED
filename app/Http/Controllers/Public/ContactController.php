<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Settings\EventSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        $settings = app(EventSettings::class);

        return Inertia::render('Public/Contact', [
            'support' => [
                'email' => $settings->support_email,
                'phone' => $settings->support_phone,
                'whatsapp' => $settings->support_whatsapp,
            ],
        ]);
    }

    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'cf-turnstile-response' => ['nullable', 'string', new \App\Rules\TurnstileRule()],
        ]);

        // TODO Phase 5+ : envoyer le mail via Notifications + stocker en BDD
        // Pour l'instant on log juste

        logger()->info('Contact form received', $validated);

        return redirect()
            ->route('contact.index')
            ->with('success', 'Votre message a été reçu. Nous vous répondrons rapidement.');
    }
}
