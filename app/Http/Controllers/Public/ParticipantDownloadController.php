<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Services\Pdf\BadgePdfService;
use App\Services\Pdf\InvoicePdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ParticipantDownloadController extends Controller
{
    public function __construct(
        protected BadgePdfService $badge,
        protected InvoicePdfService $invoice,
    ) {
    }

    /**
     * Téléchargement protégé par URL signée OU email correspondant en query.
     */
    public function __invoke(Request $request, string $reference, string $type): BinaryFileResponse|StreamedResponse
    {
        abort_unless(in_array($type, ['badge', 'invoice'], true), 404);

        $registration = Registration::with('participant')
            ->where('reference', $reference)
            ->firstOrFail();

        // Authentification : signed URL OU email match en query string
        $email = $request->query('email');
        if (! $request->hasValidSignature() && ! ($email && hash_equals(strtolower($registration->participant->email), strtolower($email)))) {
            abort(403, 'Lien invalide ou expiré.');
        }

        if ($type === 'badge') {
            if (! $registration->badge_path || ! Storage::disk('public')->exists($registration->badge_path)) {
                $this->badge->store($registration);
                $registration->refresh();
            }

            return response()->download(
                storage_path('app/public/'.$registration->badge_path),
                "badge-{$registration->reference}.pdf",
                ['Content-Type' => 'application/pdf'],
            );
        }

        // Invoice
        $invoice = $registration->morphMany(\App\Models\Invoice::class, 'billable')->latest()->first();
        if (! $invoice || ! $invoice->pdf_path || ! Storage::disk('public')->exists($invoice->pdf_path)) {
            $invoice = $this->invoice->generateForRegistration($registration);
        }

        return response()->download(
            storage_path('app/public/'.$invoice->pdf_path),
            "facture-{$invoice->number}.pdf",
            ['Content-Type' => 'application/pdf'],
        );
    }
}
