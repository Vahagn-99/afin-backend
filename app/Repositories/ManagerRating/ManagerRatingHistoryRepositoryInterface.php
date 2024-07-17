<?php

namespace App\Repositories\ManagerRating;

use App\DTO\PaginationDTO;
use App\Models\Manager;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\PaginatableWithFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

interface ManagerRatingHistoryRepositoryInterface extends PaginatableWithFilter
{
}