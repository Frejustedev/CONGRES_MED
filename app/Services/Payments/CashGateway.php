<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Models\Registration;
use App\Services\Payments\Contracts\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CashGateway implements PaymentGateway
{
    public function key(): string
    {
        return 'cash';
    }

    /**
     * Pour le paiement sur place : on crée un Payment en pending et on instruit l'user.
     * La confirmation se fait par un régisseur (admin) au moment de l'encaissement.
     */
    public function initiate(Registration $registration, array $context = []): array
    {
        $payment = Payment::create([
            'reference' => 'PAY-'.Str::upper(Str::random(12)),
            'payable_type' => $registration->getMorphClass(),
            'payable_id' => $registration->id,
            'gateway' => 'cash',
            'amount' => $registration->remainingAmount(),
            'currency' => $registration->currency,
            'status' => 'pending',
            'ip_address' => request()->ip(),
        ]);

        $registration->update(['status' => 'awaiting_payment']);

        return [
            'payment_id' => $payment->id,
            'reference' => $payment->reference,
            'redirect_url' => route('payment.return', $registration->reference).'?cash=1',
        ];
    }

    public function verify(Payment $payment): bool
    {
        // Un cash payment est validé uniquement par un régisseur (admin), pas auto.
        return $payment->status === 'completed';
    }

    public function handleWebhook(Request $request): ?Payment
    {
        return null; // pas de webhook pour le cash
    }
}
