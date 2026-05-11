<?php

namespace Database\Factories;

use App\Models\RegistrationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrationCategoryFactory extends Factory
{
    protected $model = RegistrationCategory::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(2),
            'name' => $this->faker->words(2, true),
            'currency' => 'XOF',
            'price_early_bird' => 30000,
            'price_standard' => 45000,
            'price_late' => 60000,
            'early_bird_until' => now()->addMonth(),
            'standard_until' => now()->addMonths(3),
            'is_public' => true,
            'is_active' => true,
            'display_order' => 0,
        ];
    }
}
