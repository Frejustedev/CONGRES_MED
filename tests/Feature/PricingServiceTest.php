<?php

use App\Models\PromoCode;
use App\Models\RegistrationCategory;
use App\Services\Registrations\PricingService;

beforeEach(function () {
    $this->pricing = app(PricingService::class);

    $this->category = RegistrationCategory::factory()->create([
        'slug' => 'member',
        'name' => 'Member',
        'currency' => 'XOF',
        'price_early_bird' => 30000,
        'price_standard' => 45000,
        'price_late' => 60000,
        'early_bird_until' => now()->addMonth(),
        'standard_until' => now()->addMonths(3),
        'is_active' => true,
    ]);
});

it('returns early-bird price when in early-bird window', function () {
    $result = $this->pricing->calculate($this->category);

    expect($result['base'])->toBe(30000.0);
    expect($result['tier'])->toBe('early_bird');
    expect($result['total'])->toBe(30000.0);
    expect($result['promo_valid'])->toBeFalse();
});

it('applies percentage promo code correctly', function () {
    $promo = PromoCode::create([
        'code' => 'TEST20',
        'type' => 'percentage',
        'value' => 20,
        'currency' => 'XOF',
        'is_active' => true,
        'max_uses' => 100,
        'current_uses' => 0,
    ]);

    $result = $this->pricing->calculate($this->category, 'TEST20');

    expect($result['promo_valid'])->toBeTrue();
    expect($result['discount'])->toBe(6000.0); // 20% de 30000
    expect($result['total'])->toBe(24000.0);
});

it('rejects expired promo code', function () {
    PromoCode::create([
        'code' => 'OLD',
        'type' => 'percentage',
        'value' => 50,
        'currency' => 'XOF',
        'is_active' => true,
        'valid_until' => now()->subDay(),
    ]);

    $result = $this->pricing->calculate($this->category, 'OLD');

    expect($result['promo_valid'])->toBeFalse();
    expect($result['promo_error'])->not->toBeNull();
    expect($result['total'])->toBe(30000.0);
});

it('applies free promo code', function () {
    PromoCode::create([
        'code' => 'FREE',
        'type' => 'free',
        'value' => 0,
        'currency' => 'XOF',
        'is_active' => true,
    ]);

    $result = $this->pricing->calculate($this->category, 'FREE');

    expect($result['promo_valid'])->toBeTrue();
    expect((float) $result['total'])->toBe(0.0);
});
