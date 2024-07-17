<?php

namespace App\Services\Convertor;

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