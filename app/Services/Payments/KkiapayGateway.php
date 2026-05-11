<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Models\Registration;
use App\Mail\PaymentReceived;
use App\Services\Payments\Contracts\PaymentGateway;
use App\Services\Pdf\BadgePdfService;
use App\Services\Pdf\InvoicePdfService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KkiapayGateway implements PaymentGateway
{
    public function key(): string
    {
        return 'kkiapay';
    }

    public function initiate(Registration $registration, array $context = []): array
    {
        $payment = Payment::create([
            'reference' => 'PAY-'.Str::upper(Str::random(12)),
            'payable_type' => $registration->getMorphClass(),
            'payable_id' => $registration->id,
            'gateway' => 'kkiapay',
            'amount' => $registration->remainingAmount(),
            'currency' => $registration->currency,
            'status' => 'pending',
            'ip_address' => request()->ip(),
        ]);

        return [
            'payment_id' => $payment->id,
            'reference' => $payment->reference,
            'widget_data' => [
                'public_key' => config('payments.kkiapay.public_key'),
                'sandbox' => config('payments.kkiapay.sandbox'),
                'script_url' => config('payments.kkiapay.widget_script'),
                'amount' => (int) round($payment->amount),
                'currency' => $payment->currency,
                'name' => $registration->participant->fullName(),
                'email' => $registration->participant->email,
                'phone' => $registration->participant->phone,
                'data' => $payment->reference,
                'callback' => route('payment.return', $registration->reference),
            ],
        ];
    }

    public function verify(Payment $payment): bool
    {
        if (config('payments.mode') === 'mock') {
            return $this->mockSuccess($payment);
        }

        if (! $payment->gateway_reference) {
            return false;
        }

        try {
            $client = new Client(['timeout' => 10]);
            $response = $client->post(
                config('payments.kkiapay.api_url').'/api/v1/transactions/status',
                [
                    'headers' => [
                        'X-API-KEY' => config('payments.kkiapay.public_key'),
                        'X-PRIVATE-KEY' => config('payments.kkiapay.private_key'),
                        'X-SECRET-KEY' => config('payments.kkiapay.secret'),
                        'Content-Type' => 'application/json',
                    ],
                    'json' => ['transactionId' => $payment->gateway_reference],
                ],
            );

            $data = json_decode((string) $response->getBody(), true);
            $success = ($data['status'] ?? null) === 'SUCCESS';

            if ($success) {
                $this->markSuccess($payment, $data);
            }

            return $success;
        } catch (\Throwable $e) {
            Log::error('Kkiapay verification failed', ['payment_id' => $payment->id, 'error' => $e->getMessage()]);
            return false;
        }
    }

    public function handleWebhook(Request $request): ?Payment
    {
        // Kkiapay envoie une signature HMAC dans l'en-tête (à valider)
        $signature = $request->header('X-Kkiapay-Signature');
        $secret = config('payments.kkiapay.secret');

        if ($secret && $signature) {
            $expected = hash_hmac('sha256', $request->getContent(), $secret);
            if (! hash_equals($expected, $signature)) {
                Log::warning('Kkiapay webhook signature mismatch');
                return null;
            }
        }

        $data = $request->json()->all();
        $payment = Payment::where('reference', $data['data'] ?? null)->first();

        if (! $payment) {
            Log::warning('Kkiapay webhook: payment not found', $data);
            return null;
        }

        if (($data['status'] ?? null) === 'SUCCESS') {
            $payment->update(['gateway_reference' => $data['transactionId'] ?? null]);
            $this->markSuccess($payment, $data);
        } else {
            $payment->update([
                'status' => 'failed',
                'failed_at' => now(),
                'gateway_payload' => $data,
            ]);
        }

        return $payment->refresh();
    }

    protected function markSuccess(Payment $payment, array $payload): void
    {
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
            'gateway_method' => $payload['source'] ?? $payload['transaction']['method'] ?? null,
            'gateway_payload' => $payload,
        ]);

        $registration = $payment->payable;
        if ($registration instanceof Registration) {
            $registration->update([
                'amount_paid' => $registration->amount_paid + $payment->amount,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
            $this->dispatchPostPayment($registration);
        }
    }

    protected function dispatchPostPayment(Registration $registration): void
    {
        try {
            $badgePath = app(BadgePdfService::class)->store($registration);
            $invoice = app(InvoicePdfService::class)->generateForRegistration($registration->fresh());
            Mail::send(new PaymentReceived($registration->fresh(), $invoice->pdf_path, $badgePath));
        } catch (\Throwable $e) {
            Log::warning('Post-payment dispatch failed', ['registration' => $registration->reference, 'error' => $e->getMessage()]);
        }
    }

    protected function mockSuccess(Payment $payment): bool
    {
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
            'gateway_reference' => 'MOCK-'.Str::upper(Str::random(10)),
            'gateway_method' => 'mock-mtn-momo',
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
