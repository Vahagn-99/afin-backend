<?php

namespace App\Repositories\Core;

use App\Modules\FilterManager\Filter\FiltersAggregator;

interface TransactionRepositoryInterface extends PaginatableWithFilter, Relational
{
    public function getAll(FiltersAggregator $aggregator): array;
}