<?php

namespace Database\Factories;

use App\Models\Registration;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        return [
            'reference' => 'CONG-2026-'.str_pad((string) $this->faker->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'amount_due' => 30000,
            'amount_paid' => 0,
            'currency' => 'XOF',
            'pricing_tier' => 'early_bird',
            'status' => 'awaiting_payment',
            'source' => 'online',
            'qr_token' => Str::random(48),
            'submitted_at' => now(),
        ];
    }
}
