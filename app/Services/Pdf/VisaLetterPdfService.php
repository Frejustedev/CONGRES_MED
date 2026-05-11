<?php

namespace App\Services\Pdf;

use App\Models\Registration;
use App\Settings\EventSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class VisaLetterPdfService
{
    public function generate(Registration $registration): string
    {
        $registration->loadMissing('participant');

        $event = app(EventSettings::class);

        $pdf = Pdf::loadView('pdfs.visa-letter', [
            'registration' => $registration,
            'participant' => $registration->participant,
            'event' => $event,
        ])->setPaper('a4');

        $path = sprintf('visa-letters/%s.pdf', $registration->reference);
        Storage::disk('public')->put($path, $pdf->output());

        $registration->update([
            'visa_letter_issued' => true,
            'visa_letter_path' => $path,
        ]);

        return $path;
    }
}
