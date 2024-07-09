<?php

namespace App\Services\Deposit;

use App\DTO\RateDTO;

class ConvertableDTO
{
    public function __construct(
        public float   $amount,
        public string  $currency,
        public RateDTO $rates,
    )
    {
    }
}