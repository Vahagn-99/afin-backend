<?php

namespace App\DTO;

class CloseTransactionsMonthDTO
{
    public function __construct(
        public string $date
    )
    {
    }
}