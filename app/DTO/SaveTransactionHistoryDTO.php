<?php

namespace App\DTO;

class SaveTransactionHistoryDTO
{
    public function __construct(
        public string $from,
        public string $to,
        public string $path
    )
    {
    }
}