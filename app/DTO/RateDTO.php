<?php

namespace App\DTO;

class RateDTO
{
    public function __construct(
        public float $usd,
        public float $eur,
        public float $cny,
    )
    {
    }
}