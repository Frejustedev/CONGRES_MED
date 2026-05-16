<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\SatisfactionSurvey;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SurveyController extends Controller
{
    /**
     * Form public via lien signé (envoyé par email post-event).
     */
    public function form(Request $request, string $reference): Response|RedirectResponse
    {
        if (! $request->hasValidSignature() && ! $request->query('email')) {
            abort(403, 'Lien invalide.');
        }

        $registration = Registration::with('participant')
            ->where('reference', $reference)
            ->firstOrFail();

        if (! $request->hasValidSignature()) {
            $email = $request->query('email');
            if (strtolower($registration->participant->email) !== strtolower((string) $email)) {
                abort(403, 'E-mail ne correspond pas.');
            }
        }

        // Si déjà rempli
        $existing = SatisfactionSurvey::where('registration_id', $registration->id)->first();
        if ($existing) {
            return Inertia::render('Public/Survey/Already', [
                'participant_name' => $registration->participant->fullName(),
            ]);
        }

        return Inertia::render('Public/Survey/Form', [
            'registration' => [
                'reference' => $registration->reference,
                'participant_name' => $registration->participant->fullName(),
            ],
            'topics' => [
                'IA et imagerie médicale',
                'IA en cardiologie',
                'Oncologie & IA',
                'Santé publique & big data',
                'Médecine de précision',
                'Éthique & IA',
                'Pédagogie médicale numérique',
                'Pharmacologie & ML',
                'e-Santé & téléconsultation',
            ],
        ]);
    }

    public function submit(Request $request, string $reference): RedirectResponse
    {
        $registration = Registration::where('reference', $reference)->firstOrFail();

        $validated = $request->validate([
            'nps_score' => ['nullable', 'integer', 'min:0', 'max:10'],
            'overall_rating' => ['required', 'integer', 'min:1', 'max:5'],
            'content_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'venue_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'organization_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'networking_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'topics_of_interest_next_edition' => ['nullable', 'array'],
            'positive_feedback' => ['nullable', 'string', 'max:3000'],
            'improvement_feedback' => ['nullable', 'string', 'max:3000'],
            'comments' => ['nullable', 'string', 'max:3000'],
            'would_recommend' => ['nullable', 'boolean'],
            'would_return' => ['nullable', 'boolean'],
        ]);

        SatisfactionSurvey::updateOrCreate(
            ['registration_id' => $registration->id],
            array_merge($validated, [
                'submitted_at' => now(),
                'ip_address' => $request->ip(),
            ]),
        );

        return redirect()->route('survey.thanks');
    }

    public function thanks(): Response
    {
        return Inertia::render('Public/Survey/Thanks');
    }
}
