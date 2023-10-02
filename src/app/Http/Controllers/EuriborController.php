<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreateEuriborRequest;
use App\Models\Loan;
use App\Services\Euribor\CreateEuriborService;

class EuriborController extends Controller
{

    public function __invoke(CreateEuriborRequest $request, Loan $loan): JsonResponse
    {
        /** @var int $segment */
        $segment = $request->input('segment_nr');

        /** @var int $euriborRate */
        $euriborRate = $request->input('euribor_in_basis_point');

        CreateEuriborService::createEuribor(
            loan: $loan,
            term: $segment,
            euriborRate: $euriborRate,
        );
        return $this->renderCalculations($loan);
    }
}
