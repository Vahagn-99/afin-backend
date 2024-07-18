<?php

namespace App\Modules\FilterManager\Filter;

class MakeFilterDTO
{
    public function __construct(
        public string $field,
        public mixed  $value,
    )
    {
    }
}