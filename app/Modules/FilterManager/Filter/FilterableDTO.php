<?php

namespace App\Modules\FilterManager\Filter;

class FilterableDTO
{
    public function __construct(
        public string $field,
        public mixed  $value,
    )
    {
    }
}