<?php

namespace App\Repositories\ManagerRating;

use App\DTO\PaginationDTO;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use Illuminate\Pagination\LengthAwarePaginator;

interface RatingGroupedByDateRepository
{
    public function ratings(PaginationDTO $paginationDTO, ?FiltersAggregor $filters = null): LengthAwarePaginator;
}