<?php

namespace App\Repositories\Transaction;

use App\Modules\FilterManager\Filter\FiltersAggregator;

interface TransactionRepositoryInterface
{
    public function getAll(?FiltersAggregator $aggregator = null): array;
}