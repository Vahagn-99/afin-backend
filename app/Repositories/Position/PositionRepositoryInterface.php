<?php

namespace App\Repositories\Position;

use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\PaginatableWithFilter;
use App\Repositories\Core\Relational;

interface PositionRepositoryInterface extends PaginatableWithFilter, Relational
{
    public function getAll(?FiltersAggregator $aggregator = null): array;
}