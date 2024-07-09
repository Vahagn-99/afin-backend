<?php

namespace App\Modules\FilterManager\Compare;

use Illuminate\Contracts\Database\Query\Builder;

trait HasComparing
{
    public function compare(Builder $query, MakeComparingDTO $dto): void
    {
        $query->where($dto->field, $dto->operator, $dto->value);
    }
}
