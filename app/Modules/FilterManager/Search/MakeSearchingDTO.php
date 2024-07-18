<?php

namespace App\Modules\FilterManager\Search;


readonly class MakeSearchingDTO
{
    public function __construct(
        public string $search
    )
    {
    }
}