<?php

namespace App\DTO;

class SaveManagerRatingDTO
{
    public function __construct(
        public int    $managerId,
        public string $type,
        public float  $total,
        public string $date,
    )
    {
    }
}