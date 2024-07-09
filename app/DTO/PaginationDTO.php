<?php

namespace App\DTO;

class PaginationDTO
{

    public function __construct(
        public int $page = 1,
        public int $perPage = 50,
        public array $options = []
    )
    {
    }
}