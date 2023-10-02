<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use App\Services\Loan\CalculateLoanService;
use App\Models\Loan;
use Symfony\Component\HttpFoundation\Response;
use App\Exceptions\EuriborNotFoundException;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function renderCalculations(Loan $loan, bool $showId = false): JsonResponse
    {
        try {
            $calculations = CalculateLoanService::calculateLoan($loan);

            if ($showId) {
                $calculations = [
                    'loanId' => $loan->id,
                    'schedule' => $calculations,
                ];
            }

            return response()->json($calculations);
        } catch (EuriborNotFoundException $e) {
            return response()->json(['Exception' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
