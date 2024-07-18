<?php

namespace App\Modules\FilterManager\Compare;

use App\Modules\FilterManager\Filter\FilterInterface;
use Illuminate\Contracts\Database\Query\Builder;

interface Comparable extends FilterInterface
{
    public function compare(Builder $query, MakeComparingDTO $sort): void;
}
