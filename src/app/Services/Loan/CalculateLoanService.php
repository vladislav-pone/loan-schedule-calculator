<?php

namespace App\Services\Loan;

use App\DTOs\CalculationsDto;
use App\DTOs\CalculatedMonthDto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use App\Models\Loan;
use App\Models\Euribor;
use App\Exceptions\EuriborNotFoundException;

class CalculateLoanService
{
    private function __construct()
    {
    }

    /**
     * @throws EuriborNotFoundException
     */
    public static function calculateLoan(Loan $loan): CalculationsDto
    {
        $currentEuribor = null;
        $unpaidPrincipal = $loan->amount_in_cents;
        $monthlyRate = $loan->interest_rate_in_basis_points * 0.01 * 0.01 / 12; // Point to percent and devide by months in year
        $pmt = self::monthlyPaymentByAnnuityFormula(
            interestRate: $monthlyRate,
            loanAmount: $unpaidPrincipal,
            numberOfPayments: $loan->term,
        );

        $months = Collection::times(
            $loan->term,
            function (int $number) use (&$unpaidPrincipal, &$currentEuribor, $monthlyRate, $pmt, $loan) {
                $euribor = $loan->euribors->where('term', $number)->sortBy('created_at')->last();
                if ($euribor instanceof Euribor) {
                    $currentEuribor = $euribor;
                }
                if (! $currentEuribor instanceof Euribor) {
                    throw new EuriborNotFoundException("Loan $loan->id is missing euribor record");
                }

                $currentInterestPayment = (int) round($unpaidPrincipal * $monthlyRate);
                $monthlyPrincipalPayment = (int) round($pmt - $currentInterestPayment);
                $euriborPayment = self::calculateEuriborPayment((int) $unpaidPrincipal, $currentEuribor);

                $dto = new CalculatedMonthDto(
                    segment: $number,
                    principalPaymentInCents: $monthlyPrincipalPayment,
                    interestPaymentInCents: $currentInterestPayment,
                    euriborPaymentInCents: $euriborPayment,
                    totalPaymentInCents: $pmt + $euriborPayment,
                );
                $unpaidPrincipal -= $monthlyPrincipalPayment;
                return $dto;
            }
        );
        return new CalculationsDto(...$months->all());
    }

    // PMT = (Monthly Interest Rate * Loan Amount) / (1 - (1 + Monthly Interest Rate)^(-Number of Payments))
    private static function monthlyPaymentByAnnuityFormula(
        float $interestRate,
        int $loanAmount,
        int $numberOfPayments,
    ): int
    {
        $pmt = ($interestRate * $loanAmount) / (1 - pow((1 + ($interestRate)), (-1 * $numberOfPayments)));
        return (int) ceil($pmt);
    }

    private static function calculateEuriborPayment(int $unpaidPrincipal, Euribor $euribor): int
    {
        $euriborRate = $euribor->euribor_rate_in_basis_points * 0.01 * 0.01 / 12;
        return (int) round($euriborRate * $unpaidPrincipal);
    }
}
