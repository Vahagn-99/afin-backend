<?php

namespace App\Repositories\History;

use App\DTO\SaveTransactionHistoryDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;

interface TransactionHistoryRepositoryInterface
{
    public function getAll(?FiltersAggregator $filtersAggregator = null): array;

    public function get(int $id): array;

    public function save(SaveTransactionHistoryDTO $dto): void;
}