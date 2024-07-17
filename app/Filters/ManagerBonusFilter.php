<?php

namespace App\Filters;

use App\Modules\FilterManager\Filter\FilterInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ManagerBonusFilter implements FilterInterface
{
    public function managerId(Builder $query, $value): void
    {
        $query->where('manager_id', $value);
    }

    public function managerName(Builder $query, $value): void
    {
        $query->whereHas('manager', fn($query) => $query->where('managers.name', $value));
    }

    public function date(Builder $query, $value): void
    {
        $date = Carbon::create($value);
        $query->whereYear('date', $date->year);
        $query->whereMonth('date', $date->month);
    }
}
