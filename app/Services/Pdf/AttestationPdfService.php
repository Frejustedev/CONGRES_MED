<?php

namespace App\Services\Pdf;

use App\Models\Attestation;
use App\Models\Registration;
use App\Settings\BrandingSettings;
use App\Settings\EventSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttestationPdfService
{
    public function issueAttendanceAttestation(Registration $registration): Attestation
    {
        $registration->loadMissing(['participant', 'cmeCredits.session', 'attendances.session']);

        $totalCredits = (float) $registration->cmeCredits->sum('credits');
        $sessions = $registration->cmeCredits->map(fn ($c) => [
            'title' => $c->session?->title ?? 'Session',
            'credits' => (float) $c->credits,
            'category' => $c->category,
        ])->values()->all();

        $attestation = Attestation::create([
            'reference' => 'ATT-'.now()->format('Y').'-'.Str::upper(Str::random(8)),
            'registration_id' => $registration->id,
            'type' => $totalCredits > 0 ? 'cme' : 'attendance',
            'recipient_name' => $registration->participant->fullName(),
            'recipient_email' => $registration->participant->email,
            'included_sessions' => $sessions,
            'total_credits' => $totalCredits,
            'verification_code' => Str::lower(Str::random(16)),
            'issued_at' => now(),
        ]);

        $this->renderPdf($attestation);

        return $attestation;
    }

    public function renderPdf(Attestation $attestation): string
    {
        $event = app(EventSettings::class);
        $branding = app(BrandingSettings::class);

        $pdf = Pdf::loadView('pdfs.attestation', [
            'attestation' => $attestation,
            'event' => $event,
            'branding' => $branding,
            'verifyUrl' => url('/verify/'.$attestation->verification_code),
        ])->setPaper('a4', 'landscape');

        $path = sprintf('attestations/%s.pdf', $attestation->reference);
        Storage::disk('public')->put($path, $pdf->output());
        $attestation->update(['pdf_path' => $path]);

        return $path;
    }
}
