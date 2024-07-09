<?php

namespace App\Repositories\History;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionHistoryPaginatedRepositoryInterface extends TransactionHistoryRepositoryInterface
{
    public function paginated(PaginationDTO $paginationDTO, ?FiltersAggregator $filtersAggregator = null): LengthAwarePaginator;
}