<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Registration;
use App\Services\Payments\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $payments)
    {
    }

    public function method(string $reference): Response|RedirectResponse
    {
        $registration = Registration::with(['participant', 'category'])
            ->where('reference', $reference)
            ->firstOrFail();

        if ($registration->isFullyPaid()) {
            return redirect()->route('registration.confirmation', $reference);
        }

        return Inertia::render('Public/Payment/Method', [
            'registration' => [
                'reference' => $registration->reference,
                'remaining' => $registration->remainingAmount(),
                'currency' => $registration->currency,
                'participant_name' => $registration->participant->fullName(),
                'participant_email' => $registration->participant->email,
                'category_name' => $registration->category->name,
            ],
            'gateways' => $this->payments->availableGateways($registration->currency),
            'mockMode' => config('payments.mode') === 'mock',
        ]);
    }

    public function initiate(Request $request, string $reference)
    {
        $validated = $request->validate([
            'gateway' => ['required', 'string', 'in:kkiapay,stripe,cash'],
        ]);

        $registration = Registration::where('reference', $reference)->firstOrFail();

        if ($registration->isFullyPaid()) {
            return redirect()->route('registration.confirmation', $reference);
        }

        $result = $this->payments->initiate($registration, $validated['gateway']);

        // Mock mode : on confirme directement et on redirige vers Success
        if (config('payments.mode') === 'mock' && $validated['gateway'] !== 'cash') {
            $payment = Payment::findOrFail($result['payment_id']);
            $this->payments->resolve($validated['gateway'])->verify($payment);

            return redirect()
                ->route('payment.return', $reference)
                ->with('success', 'Paiement simulé avec succès (mode mock)');
        }

        // Cash : redirige vers page d'instructions
        if ($validated['gateway'] === 'cash') {
            return redirect()->route('payment.cash-instructions', $reference);
        }

        // Stripe : redirection vers Checkout hosted
        if (isset($result['redirect_url'])) {
            return redirect()->away($result['redirect_url']);
        }

        // Kkiapay : retourne les données pour le widget JS
        return Inertia::render('Public/Payment/Widget', [
            'registration' => [
                'reference' => $registration->reference,
                'amount' => $registration->remainingAmount(),
                'currency' => $registration->currency,
            ],
            'widget' => $result['widget_data'],
        ]);
    }

    public function cashInstructions(string $reference): Response
    {
        $registration = Registration::with('participant', 'category')
            ->where('reference', $reference)
            ->firstOrFail();

        return Inertia::render('Public/Payment/CashInstructions', [
            'registration' => [
                'reference' => $registration->reference,
                'remaining' => $registration->remainingAmount(),
                'currency' => $registration->currency,
                'participant_name' => $registration->participant->fullName(),
                'category_name' => $registration->category->name,
            ],
        ]);
    }

    public function return(Request $request, string $reference): Response
    {
        $registration = Registration::with('participant', 'category')
            ->where('reference', $reference)
            ->firstOrFail();

        // Stripe : verify si session_id présent
        if ($sessionId = $request->query('stripe_session')) {
            $payment = Payment::where('gateway_reference', $sessionId)->first();
            if ($payment) {
                $this->payments->verify($payment);
            }
        }

        // Mock auto-confirm pour Stripe en mode mock
        if ($request->query('mock') && ($paymentId = $request->query('payment_id'))) {
            $payment = Payment::find($paymentId);
            if ($payment && $payment->status === 'pending') {
                $this->payments->resolve($payment->gateway)->verify($payment);
            }
        }

        $registration->refresh();

        return Inertia::render('Public/Payment/Success', [
            'registration' => [
                'reference' => $registration->reference,
                'status' => $registration->status,
                'amount_paid' => (float) $registration->amount_paid,
                'amount_due' => (float) $registration->amount_due,
                'amount_discount' => (float) $registration->amount_discount,
                'remaining' => $registration->remainingAmount(),
                'currency' => $registration->currency,
                'participant_name' => $registration->participant->fullName(),
                'participant_email' => $registration->participant->email,
                'category_name' => $registration->category->name,
                'qr_token' => $registration->qr_token,
                'confirmed_at' => $registration->confirmed_at?->toIso8601String(),
            ],
        ]);
    }

    public function cancel(string $reference): RedirectResponse
    {
        return redirect()
            ->route('payment.method', $reference)
            ->with('warning', 'Paiement annulé. Vous pouvez réessayer.');
    }
}
