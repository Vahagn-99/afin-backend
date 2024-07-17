<?php

namespace App\Repositories\ManagerRating;

use App\DTO\PaginationDTO;
use App\Models\Manager;
use App\Models\ManagerRating;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ManagerRatingHistoryRepository extends RepositoryFather implements ManagerRatingHistoryRepositoryInterface
{
    protected function setQuery(): void
    {
        $this->query = ManagerRating::query();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO): LengthAwarePaginator
    {
        return $this->getQuery()
            ->select([DB::raw("(DATE_PART('year',manager_ratings.date) || '-' || DATE_PART('month',manager_ratings.date)) as date")])
            ->groupBy(DB::raw("(DATE_PART('year',manager_ratings.date) || '-' || DATE_PART('month',manager_ratings.date))"))
            ->orderBy("date", 'desc')
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page,
            );
    }
}