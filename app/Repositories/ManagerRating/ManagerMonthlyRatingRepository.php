<?php

namespace App\Repositories\ManagerRating;

use App\DTO\PaginationDTO;
use App\Models\Manager;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ManagerMonthlyRatingRepository implements RatingGroupedByDateRepository
{

    public function ratings(PaginationDTO $paginationDTO, ?FiltersAggregor $filters = null): LengthAwarePaginator
    {
        return Manager::filter($filters)
            ->select([
                DB::raw('managers.id as id'),
                DB::raw('managers.name as name'),
                DB::raw('managers.type as type'),
                DB::raw('managers.branch as branch'),
                DB::raw('managers.avatar as avatar'),
                DB::raw("(DATE_PART('year',manager_ratings.date) || '-' || DATE_PART('month',manager_ratings.date)) as date"),
                DB::raw("MAX(CASE WHEN manager_ratings.type = 'leads_total' THEN manager_ratings.total ELSE 0 END) as leads_total"),
                DB::raw("MAX(CASE WHEN manager_ratings.type = 'deposit_total' THEN manager_ratings.total ELSE 0 END) as deposit_total"),
            ])
            ->join('manager_ratings', 'managers.id', '=', 'manager_ratings.manager_id')
            ->groupBy([
                'managers.id',
                'managers.name',
                'managers.type',
                'managers.branch',
                'managers.avatar',
                DB::raw("(DATE_PART('year',manager_ratings.date) || '-' || DATE_PART('month',manager_ratings.date))"),
            ])
            ->orderBy('deposit_total', 'desc')
            ->orderBy('leads_total', 'desc')
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page,
            );
    }
}