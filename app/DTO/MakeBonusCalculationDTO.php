<?php

namespace App\DTO;

class MakeBonusCalculationDTO
{
    public function __construct(
        public int    $managerId,
        public string $date
    )
    {
    }
}