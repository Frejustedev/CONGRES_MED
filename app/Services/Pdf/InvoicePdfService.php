<?php

namespace App\Services\Pdf;

use App\Models\Invoice;
use App\Models\Registration;
use App\Settings\EventSettings;
use App\Settings\PaymentSettings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicePdfService
{
    /**
     * Crée (ou met à jour) la facture d'une inscription puis génère le PDF.
     */
    public function generateForRegistration(Registration $registration, string $type = 'invoice'): Invoice
    {
        $registration->loadMissing(['participant', 'category']);

        $invoice = DB::transaction(function () use ($registration, $type) {
            $payment = app(PaymentSettings::class);

            // Numéro séquentiel
            $number = sprintf(
                '%s-%s-%05d',
                $payment->invoice_prefix,
                now()->format('Y'),
                $payment->invoice_next_number,
            );
            $payment->invoice_next_number += 1;
            $payment->save();

            $vatRate = (float) ($payment->vat_rate ?? 0);
            $totalTtc = (float) max(0, $registration->amount_due - $registration->amount_discount);
            $vatAmount = $vatRate > 0 ? round($totalTtc * ($vatRate / (100 + $vatRate)), 2) : 0;
            $subtotalHt = $totalTtc - $vatAmount;

            $line = [
                'description' => 'Inscription — '.$registration->category->name,
                'quantity' => 1,
                'unit_price' => (float) $registration->amount_due,
                'discount' => (float) $registration->amount_discount,
                'total' => $totalTtc,
            ];

            return Invoice::create([
                'number' => $number,
                'type' => $type,
                'billable_type' => $registration->getMorphClass(),
                'billable_id' => $registration->id,

                'issuer_name' => config('app.name'),
                'issuer_email' => app(EventSettings::class)->support_email,

                'buyer_name' => $registration->participant->fullName(),
                'buyer_organization' => $registration->participant->organization,
                'buyer_address' => $registration->participant->city,
                'buyer_country' => $registration->participant->country,
                'buyer_email' => $registration->participant->email,

                'lines' => [$line],
                'subtotal_ht' => $subtotalHt,
                'vat_amount' => $vatAmount,
                'vat_rate' => $vatRate,
                'total_ttc' => $totalTtc,
                'currency' => $registration->currency,

                'status' => $registration->isFullyPaid() ? 'paid' : 'issued',
                'issued_at' => now(),
                'paid_at' => $registration->isFullyPaid() ? now() : null,
                'legal_mentions' => $payment->invoice_legal_mentions,
            ]);
        });

        $this->renderPdf($invoice);

        return $invoice;
    }

    /**
     * Génère/regénère le PDF d'une facture existante.
     */
    public function renderPdf(Invoice $invoice): string
    {
        $event = app(EventSettings::class);

        $pdf = Pdf::loadView('pdfs.invoice', [
            'invoice' => $invoice,
            'event' => $event,
        ])->setPaper('a4');

        $bytes = $pdf->output();
        $path = sprintf('invoices/%s.pdf', $invoice->number);
        Storage::disk('public')->put($path, $bytes);

        $invoice->update(['pdf_path' => $path]);

        return $path;
    }
}
