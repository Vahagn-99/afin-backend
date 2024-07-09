<?php

namespace App\Modules\FilterManager\Sort;


readonly class MakeSortingDTO
{
    public function __construct(
        public string $attribute,
        public string $direction
    )
    {
    }
}