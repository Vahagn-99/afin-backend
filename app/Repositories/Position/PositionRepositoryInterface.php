<?php

namespace App\Repositories\Position;

use App\Modules\FilterManager\Filter\FiltersAggregator;

interface PositionRepositoryInterface
{
    public function getAll(?FiltersAggregator $aggregator = null): array;
}