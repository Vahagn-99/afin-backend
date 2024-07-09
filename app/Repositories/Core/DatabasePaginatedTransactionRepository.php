<?php

namespace App\Repositories\Core;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use Illuminate\Pagination\LengthAwarePaginator;

interface DatabasePaginatedTransactionRepository
{
    public function paginated(FiltersAggregator $filtersAggregator, PaginationDTO $paginationDTO): LengthAwarePaginator;
}