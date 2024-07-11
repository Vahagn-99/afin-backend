<?php

namespace App\Repositories\Transaction;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\Relational;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClosedTransactionRepositoryInterface extends Relational
{
    public function getAllByHistoryId(int $historyId, PaginationDTO $paginationDTO, ?FiltersAggregator $aggregator = null): LengthAwarePaginator;

    public function saveBatchByHistoryId(int $historyId, array $transactions);
}