<?php

namespace App\DTO;

class SaveArchiveDTO
{
    public function __construct(
        public string $from,
        public string $to,
        public string $closet_at,
    )
    {
    }
}