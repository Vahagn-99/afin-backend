<?php

namespace App\Repositories\History;

use App\DTO\SaveTransactionHistoryDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\PaginatableWithFilter;

interface TransactionHistoryRepositoryInterface extends PaginatableWithFilter
{
    public function getAll(?FiltersAggregator $filtersAggregator = null): array;

    public function get(int $id): array;

    public function save(SaveTransactionHistoryDTO $dto): int;
}