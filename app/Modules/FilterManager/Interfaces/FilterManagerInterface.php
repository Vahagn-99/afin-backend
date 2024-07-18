<?php

namespace App\Modules\FilterManager\Interfaces;

use App\Modules\FilterManager\Filter\FilterInterface;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use Illuminate\Contracts\Database\Query\Builder;

interface FilterManagerInterface
{
    public function apply(Builder $query, FilterInterface $filter, FiltersAggregor $filters): Builder;
}