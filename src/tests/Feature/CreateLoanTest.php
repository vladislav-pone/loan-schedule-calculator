<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\Euribor;
use Tests\TestCase;

class CreateLoanTest extends TestCase
{
    public const URI = '/api/loans';

    public function test_loan_can_be_created(): void
    {
        $instance = Loan::factory()->make();
        $euriborInstance = Euribor::factory()->make();
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );

        $response->assertStatus(200);
    }

    public function test_loan_can_not_be_created_without_data(): void
    {
        $instance = Loan::factory()->make();
        $euriborInstance = Euribor::factory()->make();
        $response = $this->POST(self::URI);

        $response->assertStatus(422);
    }

    public function test_loan_can_not_be_created_without_principal(): void
    {
        $instance = Loan::factory()->make();
        $euriborInstance = Euribor::factory()->make();
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => 0,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => -10,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => "amount_in_cents",
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
    }

    public function test_loan_can_not_be_created_without_term(): void
    {
        $instance = Loan::factory()->make();
        $euriborInstance = Euribor::factory()->make();
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => 0,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => -10,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => 'term',
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
    }

    public function test_loan_can_not_be_created_without_interest_rate(): void
    {
        $instance = Loan::factory()->make();
        $euriborInstance = Euribor::factory()->make();
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => "-10",
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => "interest_rate_in_basis_points",
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => $instance->term,
                'euribor_rate_in_basis_points' => $euriborInstance->euribor_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
    }

    public function test_loan_can_not_be_created_without_euribor_rate(): void
    {
        $instance = Loan::factory()->make();
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => "-10",
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
                'euribor_rate_in_basis_points' => "euribor_rate_in_basis_points",
            ]
        );
        $response->assertStatus(422);
        $response = $this->POST(
            self::URI,
            [
                'amount_in_cents' => $instance->amount_in_cents,
                'term' => $instance->term,
                'interest_rate_in_basis_points' => $instance->interest_rate_in_basis_points,
            ]
        );
        $response->assertStatus(422);
    }
}
