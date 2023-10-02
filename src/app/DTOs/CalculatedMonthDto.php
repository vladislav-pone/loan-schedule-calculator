<?php

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

readonly class CalculatedMonthDto implements Arrayable, Jsonable
{
    public function __construct(
        public int $segment,
        public int $principalPaymentInCents,
        public int $interestPaymentInCents,
        public int $euriborPaymentInCents,
        public int $totalPaymentInCents,
    )
    {
    }

    /**
     * @return array<string, int>
     */
    public function toArray()
    {
        return [
            'segment' => $this->segment,
            'principalPaymentInCents' => $this->principalPaymentInCents,
            'interestPaymentInCents' => $this->interestPaymentInCents,
            'euriborPaymentInCents' => $this->euriborPaymentInCents,
            'totalPaymentInCents' => $this->totalPaymentInCents,
        ];
    }

    /**
     * @return string
     */
    public function toJson($options = 0)
    {
        return (string) \json_encode($this->toArray(), $options);
    }
}
