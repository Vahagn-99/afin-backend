<?php

namespace App\DTO;

class CloseMonthDTO
{
    public function __construct(
        public string $closedAt
    )
    {
    }
}