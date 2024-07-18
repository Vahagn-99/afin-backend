<?php

namespace App\Repositories\ArchivedTransaction;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\Relational;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArchivedTransactionRepositoryInterface extends Relational
{
    public function getAllByHistoryId(int $historyId, PaginationDTO $paginationDTO, ?FiltersAggregor $aggregator = null): LengthAwarePaginator;

    public function getAll(?FiltersAggregor $aggregator = null): array;

    public function saveBatchByArchiveId(int $archivedId, array $transactions);

}