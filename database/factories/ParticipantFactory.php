<?php

namespace Database\Factories;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'salutation' => 'Dr',
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'organization' => $this->faker->company(),
            'specialty' => 'Médecine générale',
            'city' => 'Cotonou',
            'country' => 'BJ',
            'preferred_locale' => 'fr',
        ];
    }
}
