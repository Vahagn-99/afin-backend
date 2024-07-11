<?php

namespace App\Repositories\Core;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use Illuminate\Pagination\LengthAwarePaginator;

interface PaginatableWithFilter
{
    public function paginateWithFilter(PaginationDTO $paginationDTO, FiltersAggregator $filters): LengthAwarePaginator;
}