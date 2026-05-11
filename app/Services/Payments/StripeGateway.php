<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Models\Registration;
use App\Services\Payments\Contracts\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeGateway implements PaymentGateway
{
    public function key(): string
    {
        return 'stripe';
    }

    public function initiate(Registration $registration, array $context = []): array
    {
        $payment = Payment::create([
            'reference' => 'PAY-'.Str::upper(Str::random(12)),
            'payable_type' => $registration->getMorphClass(),
            'payable_id' => $registration->id,
            'gateway' => 'stripe',
            'amount' => $registration->remainingAmount(),
            'currency' => strtolower($registration->currency === 'XOF' ? 'eur' : $registration->currency),
            'status' => 'pending',
            'ip_address' => request()->ip(),
        ]);

        if (config('payments.mode') === 'mock' || ! config('payments.stripe.secret')) {
            // Mock : on auto-confirme à l'arrivée sur la return URL
            return [
                'payment_id' => $payment->id,
                'reference' => $payment->reference,
                'redirect_url' => route('payment.return', $registration->reference).'?mock=1&payment_id='.$payment->id,
            ];
        }

        try {
            $stripe = new StripeClient(config('payments.stripe.secret'));

            $session = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => $payment->currency,
                        'product_data' => [
                            'name' => 'Inscription congrès — '.$registration->reference,
                        ],
                        'unit_amount' => (int) round($payment->amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'customer_email' => $registration->participant->email,
                'client_reference_id' => $payment->reference,
                'metadata' => [
                    'payment_id' => (string) $payment->id,
                    'registration_id' => (string) $registration->id,
                ],
                'success_url' => route('payment.return', $registration->reference).'?stripe_session={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', $registration->reference),
            ]);

            $payment->update(['gateway_reference' => $session->id]);

            return [
                'payment_id' => $payment->id,
                'reference' => $payment->reference,
                'redirect_url' => $session->url,
            ];
        } catch (\Throwable $e) {
            Log::error('Stripe session creation failed', ['error' => $e->getMessage()]);
            $payment->update(['status' => 'failed', 'failed_at' => now()]);
            throw $e;
        }
    }

    public function verify(Payment $payment): bool
    {
        if (config('payments.mode') === 'mock') {
            return $this->mockSuccess($payment);
        }

        if (! $payment->gateway_reference || ! config('payments.stripe.secret')) {
            return false;
        }

        try {
            $stripe = new StripeClient(config('payments.stripe.secret'));
            $session = $stripe->checkout->sessions->retrieve($payment->gateway_reference);

            if ($session->payment_status === 'paid') {
                $this->markSuccess($payment, $session->toArray());
                return true;
            }
        } catch (\Throwable $e) {
            Log::error('Stripe verification failed', ['error' => $e->getMessage()]);
        }

        return false;
    }

    public function handleWebhook(Request $request): ?Payment
    {
        $secret = config('payments.stripe.webhook_secret');
        if (! $secret) {
            Log::warning('Stripe webhook secret not configured');
            return null;
        }

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature') ?? '',
                $secret,
            );
        } catch (\Throwable $e) {
            Log::warning('Stripe webhook signature invalid', ['error' => $e->getMessage()]);
            return null;
        }

        if ($event->type !== 'checkout.session.completed') {
            return null;
        }

        $session = $event->data->object;
        $payment = Payment::where('reference', $session->client_reference_id)->first();

        if ($payment) {
            $this->markSuccess($payment, $session->toArray());
        }

        return $payment;
    }

    protected function markSuccess(Payment $payment, array $payload): void
    {
        if ($payment->status === 'completed') {
            return;
        }

        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
            'gateway_method' => 'card',
            'gateway_payload' => $payload,
        ]);

        $registration = $payment->payable;
        if ($registration instanceof Registration) {
            $registration->update([
                'amount_paid' => $registration->amount_paid + $payment->amount,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
        }
    }

    protected function mockSuccess(Payment $payment): bool
    {
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
            'gateway_reference' => 'MOCK-STRIPE-'.Str::upper(Str::random(8)),
            'gateway_method' => 'mock-card',
            'gateway_payload' => ['mode' => 'mock', 'simulated' => true],
        ]);

        $registration = $payment->payable;
        if ($registration instanceof Registration) {
            $registration->update([
                'amount_paid' => $registration->amount_paid + $payment->amount,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
        }

        return true;
    }
}
