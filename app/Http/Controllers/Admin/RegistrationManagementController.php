<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Services\Pdf\BadgePdfService;
use App\Services\Pdf\InvoicePdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RegistrationManagementController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Registration::with(['participant', 'category', 'promoCode']);

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($q = $request->query('q')) {
            $query->where(function ($w) use ($q) {
                $w->where('reference', 'like', "%{$q}%")
                  ->orWhereHas('participant', fn ($p) => $p->where('email', 'like', "%{$q}%")
                      ->orWhere('first_name', 'like', "%{$q}%")
                      ->orWhere('last_name', 'like', "%{$q}%"));
            });
        }

        $registrations = $query
            ->latest()
            ->paginate(25)
            ->through(fn ($r) => [
                'id' => $r->id,
                'reference' => $r->reference,
                'participant' => $r->participant->fullName(),
                'email' => $r->participant->email,
                'organization' => $r->participant->organization,
                'country' => $r->participant->country,
                'category' => $r->category->name,
                'status' => $r->status,
                'amount_due' => (float) $r->amount_due,
                'amount_paid' => (float) $r->amount_paid,
                'currency' => $r->currency,
                'visa_requested' => $r->visa_letter_requested,
                'visa_issued' => $r->visa_letter_issued,
                'checked_in' => $r->checked_in_at !== null,
                'created_at' => $r->created_at->toIso8601String(),
            ]);

        return Inertia::render('Admin/Registrations/Index', [
            'registrations' => $registrations,
            'filters' => $request->only(['status', 'q']),
            'statuses' => [
                'pending', 'awaiting_payment', 'confirmed', 'cancelled', 'refunded',
            ],
        ]);
    }

    public function regenerateBadge(int $registrationId, BadgePdfService $badge): RedirectResponse
    {
        $registration = Registration::findOrFail($registrationId);
        $badge->store($registration);

        return back()->with('success', 'Badge régénéré.');
    }

    public function regenerateInvoice(int $registrationId, InvoicePdfService $invoice): RedirectResponse
    {
        $registration = Registration::findOrFail($registrationId);
        $invoice->generateForRegistration($registration);

        return back()->with('success', 'Facture régénérée.');
    }

    public function cancel(Request $request, int $registrationId): RedirectResponse
    {
        $registration = Registration::findOrFail($registrationId);
        $reason = $request->input('reason', 'Annulation administrative');

        $registration->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);

        return back()->with('success', 'Inscription annulée.');
    }

    public function exportCsv(Request $request)
    {
        $registrations = Registration::with(['participant', 'category'])
            ->orderBy('created_at')
            ->get();

        $filename = 'inscriptions-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($registrations) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM UTF-8 pour Excel
            fputcsv($out, [
                'Référence', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Organisation',
                'Pays', 'Catégorie', 'Tier', 'Montant dû', 'Montant payé', 'Devise',
                'Statut', 'Visa demandé', 'Check-in', 'Créé le',
            ], ';');
            foreach ($registrations as $r) {
                fputcsv($out, [
                    $r->reference,
                    $r->participant->last_name,
                    $r->participant->first_name,
                    $r->participant->email,
                    $r->participant->phone,
                    $r->participant->organization,
                    $r->participant->country,
                    $r->category->name,
                    $r->pricing_tier,
                    $r->amount_due,
                    $r->amount_paid,
                    $r->currency,
                    $r->status,
                    $r->visa_letter_requested ? 'oui' : 'non',
                    $r->checked_in_at?->format('Y-m-d H:i:s'),
                    $r->created_at->format('Y-m-d H:i:s'),
                ], ';');
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
