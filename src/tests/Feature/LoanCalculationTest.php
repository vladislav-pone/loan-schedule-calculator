<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Loan;
use App\Models\Euribor;

class LoanCalculationTest extends TestCase
{
    public const URI = '/api/loans/';

    public function test_loan_calculation_with_known_values_without_euribor_changes(): void
    {
        $loan = Loan::factory()->hasEuribors(1, [
            'term' => 1,
            'euribor_rate_in_basis_points' => 394,
        ])->create([
            'amount_in_cents' => 1000000,
            'term' => 12,
            'interest_rate_in_basis_points' => 400,
        ]);
        $response = $this->get(self::URI . (string) $loan->id);
        $response->assertStatus(200)->assertJson([
            [
                "segment" => 1,
                "principalPaymentInCents" => 81817,
                "interestPaymentInCents" => 3333,
                "euriborPaymentInCents" => 3283,
                "totalPaymentInCents" => 88433,
            ],
            [
                "segment" => 2,
                "principalPaymentInCents" => 82089,
                "interestPaymentInCents" => 3061,
                "euriborPaymentInCents" => 3015,
                "totalPaymentInCents" => 88165,
            ],
            [
                "segment" => 3,
                "principalPaymentInCents" => 82363,
                "interestPaymentInCents" => 2787,
                "euriborPaymentInCents" => 2745,
                "totalPaymentInCents" => 87895,
            ],
            [
                "segment" => 4,
                "principalPaymentInCents" => 82638, // Changed example from 82637, as $principalPaymentInCents + $interestPaymentInCents !== 85150 as everywhere else
                "interestPaymentInCents" => 2512,
                "euriborPaymentInCents" => 2475,
                "totalPaymentInCents" => 87625,
            ],
            [
                "segment" => 5,
                "principalPaymentInCents" => 82913,
                "interestPaymentInCents" => 2237,
                "euriborPaymentInCents" => 2203,
                "totalPaymentInCents" => 87353,
            ],
            [
                "segment" => 6,
                "principalPaymentInCents" => 83189,
                "interestPaymentInCents" => 1961,
                "euriborPaymentInCents" => 1931,
                "totalPaymentInCents" => 87081,
            ],
            [
                "segment" => 7,
                "principalPaymentInCents" => 83467,
                "interestPaymentInCents" => 1683,
                "euriborPaymentInCents" => 1658,
                "totalPaymentInCents" => 86808,
            ],
            [
                "segment" => 8,
                "principalPaymentInCents" => 83745,
                "interestPaymentInCents" => 1405,
                "euriborPaymentInCents" => 1384,
                "totalPaymentInCents" => 86534,
            ],
            [
                "segment" => 9,
                "principalPaymentInCents" => 84024,
                "interestPaymentInCents" => 1126,
                "euriborPaymentInCents" => 1109,
                "totalPaymentInCents" => 86259,
            ],
            [
                "segment" => 10,
                "principalPaymentInCents" => 84304,
                "interestPaymentInCents" => 846,
                "euriborPaymentInCents" => 833,
                "totalPaymentInCents" => 85983,
            ],
            [
                "segment" => 11,
                "principalPaymentInCents" => 84585,
                "interestPaymentInCents" => 565,
                "euriborPaymentInCents" => 556,
                "totalPaymentInCents" => 85706,
            ],
            [
                "segment" => 12,
                "principalPaymentInCents" => 84867,
                "interestPaymentInCents" => 283,
                "euriborPaymentInCents" => 279,
                "totalPaymentInCents" => 85429,
            ],
        ]);
    }
    public function test_loan_calculation_with_known_values_including_euribor_changes(): void
    {
        $loan = Loan::factory()->hasEuribors(1, [
            'term' => 1,
            'euribor_rate_in_basis_points' => 394,
        ])->create([
            'amount_in_cents' => 1000000,
            'term' => 12,
            'interest_rate_in_basis_points' => 400,
        ]);
        $euriborInstance = Euribor::factory()->for($loan)->create([
            'term' => 6,
            'euribor_rate_in_basis_points' => 410,
        ]);
        $response = $this->get(self::URI . (string) $loan->id);
        $response->assertStatus(200)->assertJson([
            [
                "segment" => 1,
                "principalPaymentInCents" => 81817,
                "interestPaymentInCents" => 3333,
                "euriborPaymentInCents" => 3283,
                "totalPaymentInCents" => 88433,
            ],
            [
                "segment" => 2,
                "principalPaymentInCents" => 82089,
                "interestPaymentInCents" => 3061,
                "euriborPaymentInCents" => 3015,
                "totalPaymentInCents" => 88165,
            ],
            [
                "segment" => 3,
                "principalPaymentInCents" => 82363,
                "interestPaymentInCents" => 2787,
                "euriborPaymentInCents" => 2745,
                "totalPaymentInCents" => 87895,
            ],
            [
                "segment" => 4,
                "principalPaymentInCents" => 82638,
                "interestPaymentInCents" => 2512,
                "euriborPaymentInCents" => 2475,
                "totalPaymentInCents" => 87625,
            ],
            [
                "segment" => 5,
                "principalPaymentInCents" => 82913,
                "interestPaymentInCents" => 2237,
                "euriborPaymentInCents" => 2203,
                "totalPaymentInCents" => 87353,
            ],
            [
                "segment" => 6,
                "principalPaymentInCents" => 83189,
                "interestPaymentInCents" => 1961,
                "euriborPaymentInCents" => 2010,
                "totalPaymentInCents" => 87160,
            ],
            [
                "segment" => 7,
                "principalPaymentInCents" => 83467,
                "interestPaymentInCents" => 1683,
                "euriborPaymentInCents" => 1725,
                "totalPaymentInCents" => 86875,
            ],
            [
                "segment" => 8,
                "principalPaymentInCents" => 83745,
                "interestPaymentInCents" => 1405,
                "euriborPaymentInCents" => 1440,
                "totalPaymentInCents" => 86590,
            ],
            [
                "segment" => 9,
                "principalPaymentInCents" => 84024,
                "interestPaymentInCents" => 1126,
                "euriborPaymentInCents" => 1154,
                "totalPaymentInCents" => 86304,
            ],
            [
                "segment" => 10,
                "principalPaymentInCents" => 84304,
                "interestPaymentInCents" => 846,
                "euriborPaymentInCents" => 867,
                "totalPaymentInCents" => 86017,
            ],
            [
                "segment" => 11,
                "principalPaymentInCents" => 84585,
                "interestPaymentInCents" => 565,
                "euriborPaymentInCents" => 579,
                "totalPaymentInCents" => 85729,
            ],
            [
                "segment" => 12,
                "principalPaymentInCents" => 84867,
                "interestPaymentInCents" => 283,
                "euriborPaymentInCents" => 290,
                "totalPaymentInCents" => 85440,
            ],

        ]);
    }
}
