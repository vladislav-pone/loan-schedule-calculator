<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreateLoanRequest;
use App\Http\Requests\UpdateLoanRequest;

class LoanController extends Controller
{
    public function show(string $id): JsonResponse
    {
        return response()->json([]); // TODO implement logic
    }

    public function store(CreateLoanRequest $request): JsonResponse
    {
        return response()->json([]); // TODO implement logic
    }

    public function update(UpdateLoanRequest $request, string $id): JsonResponse
    {
        return response()->json([]); // TODO implement logic
    }
}
