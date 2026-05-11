<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Services\Payments\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function __construct(protected PaymentService $payments)
    {
    }

    public function kkiapay(Request $request): JsonResponse
    {
        Log::info('Kkiapay webhook received', ['headers' => $request->headers->all()]);
        $payment = $this->payments->resolve('kkiapay')->handleWebhook($request);

        return response()->json(['received' => true, 'payment_status' => $payment?->status]);
    }

    public function stripe(Request $request): JsonResponse
    {
        Log::info('Stripe webhook received');
        $payment = $this->payments->resolve('stripe')->handleWebhook($request);

        return response()->json(['received' => true, 'payment_status' => $payment?->status]);
    }
}
