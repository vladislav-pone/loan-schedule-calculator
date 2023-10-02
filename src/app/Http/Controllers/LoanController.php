<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreateLoanRequest;
use App\Models\Loan;
use App\Services\Loan\CreateLoanService;

class LoanController extends Controller
{
    public function show(Loan $loan): JsonResponse
    {
        return $this->renderCalculations($loan);
    }

    public function store(CreateLoanRequest $request): JsonResponse
    {
        /** @var numeric-string $amountInCents */
        $amountInCents = $request->input('amount_in_cents');

        /** @var int $term */
        $term = $request->input('term');

        /** @var int $interestRateInBasisPoints */
        $interestRateInBasisPoints = $request->input('interest_rate_in_basis_points');

        /** @var int $euriborRateInBasisPoints */
        $euriborRateInBasisPoints = $request->input('euribor_rate_in_basis_points');

        $loan = CreateLoanService::createLoan(
            amount: $amountInCents,
            term: $term,
            interestRate: $interestRateInBasisPoints,
            euriborRate: $euriborRateInBasisPoints,
        );
        return $this->renderCalculations($loan, true);
    }
}
