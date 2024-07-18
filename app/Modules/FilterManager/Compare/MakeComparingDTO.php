<?php

namespace App\Modules\FilterManager\Compare;

class MakeComparingDTO
{
    public function __construct(
        public string $field,
        public string $operator,
        public mixed  $value,
    )
    {
    }
}