<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Attestation;
use Inertia\Inertia;
use Inertia\Response;

class VerifyController extends Controller
{
    public function __invoke(string $code): Response
    {
        $attestation = Attestation::where('verification_code', $code)
            ->whereNull('revoked_at')
            ->with('registration.participant', 'registration.category')
            ->first();

        return Inertia::render('Public/Verify', [
            'attestation' => $attestation ? [
                'reference' => $attestation->reference,
                'recipient_name' => $attestation->recipient_name,
                'type' => $attestation->type,
                'total_credits' => (float) $attestation->total_credits,
                'issued_at' => $attestation->issued_at->toIso8601String(),
                'event_name' => config('app.name'),
            ] : null,
            'verified' => (bool) $attestation,
        ]);
    }
}
