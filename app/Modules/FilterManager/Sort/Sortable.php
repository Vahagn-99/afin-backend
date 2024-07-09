<?php

namespace App\Modules\FilterManager\Sort;

use App\Modules\FilterManager\Filter\FilterInterface;
use Illuminate\Contracts\Database\Query\Builder;

interface Sortable extends FilterInterface
{
    public function sort(Builder $query, MakeSortingDTO $sort): void;
}
