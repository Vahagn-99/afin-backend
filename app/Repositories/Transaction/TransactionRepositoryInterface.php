<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\PaginatableWithFilter;
use App\Repositories\Core\Relational;

interface TransactionRepositoryInterface extends Relational, PaginatableWithFilter
{
    public function getAll(?FiltersAggregor $aggregator = null): array;

    public function truncate(): void;
    public function getById(int $id): Transaction;
}