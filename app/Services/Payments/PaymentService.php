<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Models\Registration;
use App\Services\Payments\Contracts\PaymentGateway;
use InvalidArgumentException;

class PaymentService
{
    public function __construct(
        protected KkiapayGateway $kkiapay,
        protected StripeGateway $stripe,
        protected CashGateway $cash,
    ) {
    }

    /**
     * Liste les gateways disponibles selon la config + devise.
     */
    public function availableGateways(string $currency): array
    {
        return collect(config('payments.available_gateways'))
            ->filter(fn ($g) => ($g['enabled'] ?? false) && in_array($currency, $g['currencies'], true))
            ->all();
    }

    public function resolve(string $gateway): PaymentGateway
    {
        return match ($gateway) {
            'kkiapay' => $this->kkiapay,
            'stripe' => $this->stripe,
            'cash' => $this->cash,
            default => throw new InvalidArgumentException("Gateway inconnu : {$gateway}"),
        };
    }

    public function initiate(Registration $registration, string $gateway, array $context = []): array
    {
        return $this->resolve($gateway)->initiate($registration, $context);
    }

    public function verify(Payment $payment): bool
    {
        return $this->resolve($payment->gateway)->verify($payment);
    }
}
