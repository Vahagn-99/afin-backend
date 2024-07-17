<?php

namespace App\DTO;

class FindBonusDTO
{
    public function __construct(
        public int    $managerId,
        public int    $contactId,
        public string $date,
    )
    {
    }
}