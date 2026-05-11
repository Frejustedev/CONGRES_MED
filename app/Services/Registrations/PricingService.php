<?php

namespace App\Services\Registrations;

use App\Models\PromoCode;
use App\Models\RegistrationCategory;

class PricingService
{
    /**
     * Calcule le prix final d'une inscription.
     *
     * @return array{base: float, tier: string, discount: float, discount_label: ?string, total: float, currency: string, promo_valid: bool, promo_error: ?string}
     */
    public function calculate(RegistrationCategory $category, ?string $promoCode = null): array
    {
        $base = $category->currentPrice();
        $tier = $category->currentTier();
        $currency = $category->currency;

        $discount = 0.0;
        $discountLabel = null;
        $promoValid = false;
        $promoError = null;

        if ($promoCode) {
            $promo = PromoCode::where('code', $promoCode)->first();

            if (! $promo) {
                $promoError = 'Code promo introuvable.';
            } elseif (! $promo->isUsable()) {
                $promoError = 'Code promo expiré ou épuisé.';
            } elseif ($promo->applicable_categories && ! in_array($category->id, $promo->applicable_categories, true)) {
                $promoError = 'Code promo non applicable à cette catégorie.';
            } else {
                $promoValid = true;
                $discount = match ($promo->type) {
                    'percentage' => round($base * ((float) $promo->value / 100), 2),
                    'fixed' => min($base, (float) $promo->value),
                    'free' => $base,
                    default => 0.0,
                };
                $discountLabel = match ($promo->type) {
                    'percentage' => "-{$promo->value} %",
                    'fixed' => "-{$promo->value} {$currency}",
                    'free' => 'Gratuit',
                    default => null,
                };
            }
        }

        return [
            'base' => $base,
            'tier' => $tier,
            'discount' => $discount,
            'discount_label' => $discountLabel,
            'total' => max(0, $base - $discount),
            'currency' => $currency,
            'promo_valid' => $promoValid,
            'promo_error' => $promoError,
        ];
    }
}
