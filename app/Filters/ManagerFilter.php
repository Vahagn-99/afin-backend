<?php

namespace App\Filters;

use App\Modules\FilterManager\Filter\FilterInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ManagerFilter implements FilterInterface
{
    public function month(Builder $query, $value): void
    {
        $query->whereMonth('manager_ratings.date', '=', Carbon::createFromFormat('Y-m', $value)->month);
        $query->whereYear('manager_ratings.date', '=', Carbon::createFromFormat('Y-m', $value)->year);
    }

    public function year(Builder $query, $value): void
    {
        $query->whereYear('manager_ratings.date', '=', $value);
    }

    public function managerBranch(Builder $query, $value): void
    {
        $query->where('managers.branch', 'LIKE', "%$value%");
    }

    public function managerName(Builder $query, $value): void
    {
        $query->where('managers.name', 'LIKE', "%$value%");
    }
}
