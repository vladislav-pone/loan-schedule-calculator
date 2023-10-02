<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount_in_cents' => fake()->numberBetween(1000, 10000000000), // random from 10$ to 10 millions
            'term' => fake()->numberBetween(2, 360), // random from 2 month to 30 years
            'interest_rate_in_basis_points' => fake()->numberBetween(1, 10000), // random from 0.01% to 100%
            'created_at' => now(),
        ];
    }
}
