<?php

namespace App\Modules\FilterManager\Interfaces;

use App\Modules\FilterManager\Filter\FilterInterface;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use Illuminate\Contracts\Database\Query\Builder;

interface FilterManagerInterface
{
    public function apply(Builder $query, FilterInterface $filter, FiltersAggregator $filters): Builder;
}