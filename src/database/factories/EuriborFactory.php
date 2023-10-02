<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Euribor>
 */
class EuriborFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'term' => fake()->numberBetween(2, 360), // random from 2 month to 30 years
            'euribor_rate_in_basis_points' => fake()->numberBetween(1, 10000), // random from 0.01% to 100%
            'created_at' => now(),
        ];
    }
}
