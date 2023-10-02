<?php

namespace App\Services\Euribor;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Loan;
use App\Models\Euribor;

class CreateEuriborService
{
    private function __construct()
    {
    }

    public static function createEuribor(Loan $loan, int $term, int $euriborRate): void
    {
        $euribor = Euribor::create([
            'loan_id' => $loan->id,
            'term' => $term,
            'euribor_rate_in_basis_points' => $euriborRate,
        ]);
        $loan->load('euribors');
    }
}
