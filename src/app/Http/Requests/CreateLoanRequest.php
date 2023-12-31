<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class CreateLoanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount_in_cents' => 'required|numeric|gt:0', // The principal loan amount in cents.
            'term' => 'required|numeric|gt:0', // The loan term in months.
            'interest_rate_in_basis_points' => 'required|numeric|gte:0', // The initial interest rate in basis points (1 basis point = 0.01%).
            'euribor_rate_in_basis_points' => 'required|numeric|gte:0', // The initial Euribor rate as a percentage. Can change later.
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
