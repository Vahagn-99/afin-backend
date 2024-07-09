<?php

namespace App\Modules\FilterManager\Compare;

use App\Modules\FilterManager\Filter\FilterInterface;
use App\Modules\FilterManager\Sort\MakeSortingDTO;
use Illuminate\Contracts\Database\Query\Builder;

interface Comparable extends FilterInterface
{
    public function sort(Builder $query, MakeSortingDTO $sort): void;
}
