<?php

namespace App\Repositories\Position;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use Illuminate\Pagination\AbstractPaginator;

interface PositionPaginatedRepositoryInterface extends PositionRepositoryInterface
{
    public function getAllPaginated(PaginationDTO $paginationDTO, ?FiltersAggregator $aggregator = null): AbstractPaginator;
}