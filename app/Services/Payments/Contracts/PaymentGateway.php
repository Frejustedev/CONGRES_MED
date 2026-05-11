<?php

namespace App\Services\Payments\Contracts;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;

interface PaymentGateway
{
    /**
     * Identifiant court du gateway (kkiapay, stripe, cash, ...).
     */
    public function key(): string;

    /**
     * Initie une transaction et retourne les données pour le client.
     *
     * @return array{payment_id: int, redirect_url?: string, widget_data?: array, reference: string}
     */
    public function initiate(Registration $registration, array $context = []): array;

    /**
     * Vérifie le statut d'une transaction auprès du provider.
     */
    public function verify(Payment $payment): bool;

    /**
     * Traite un webhook reçu du provider (vérifie signature + met à jour Payment).
     *
     * @return Payment|null Le paiement mis à jour si la requête est valide.
     */
    public function handleWebhook(Request $request): ?Payment;
}
