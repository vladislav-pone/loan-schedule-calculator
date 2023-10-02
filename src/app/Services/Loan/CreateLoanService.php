<?php

namespace App\Services\Loan;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Loan;
use App\Models\Euribor;
use App\Services\Euribor\CreateEuriborService;

class CreateLoanService
{
    private function __construct()
    {
    }

    /**
     * @param numeric-string $amount
     */
    public static function createLoan(string $amount, int $term, int $interestRate, int $euriborRate): Loan
    {
        $loan = Loan::create([
            'amount_in_cents' => $amount,
            'term' => $term,
            'interest_rate_in_basis_points' => $interestRate,
        ]);

        CreateEuriborService::createEuribor(
            loan: $loan,
            term: 1,
            euriborRate: $euriborRate,
        );

        return $loan;
    }
}
