<?php

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

readonly class CalculationsDto implements Arrayable, Jsonable
{
    /** @var CalculatedMonthDto[] */
    public array $months;

    public function __construct(
        CalculatedMonthDto ...$months,
    )
    {
        $this->months = $months; // Cannot declare variadic prompted property
    }

    /**
     * @return CalculatedMonthDto[]
     */
    public function toArray()
    {
        return $this->months;
    }

    /**
     * @return string
     */
    public function toJson($options = 0)
    {
        return (string) \json_encode($this->toArray(), $options);
    }
}
