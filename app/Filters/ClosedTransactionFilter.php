<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Modules\FilterManager\Sort\Sortable;
use App\Modules\FilterManager\Sort\HasSorting;
use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Compare\HasComparing;
use Illuminate\Support\Carbon;

class ClosedTransactionFilter implements Sortable, Comparable
{
    use HasSorting, HasComparing;

    public function historyId(Builder $query, int $id): void
    {
        $query->where('closed_transactions.history_id', $id);
    }

    public function lk(Builder $query, int $value): void
    {
        $query->where('closed_transactions.lk', $value);
    }

    public function login(Builder $query, int $value): void
    {
        $query->where('closed_transactions.login', $value);
    }

    public function logins(Builder $query, array $logins): void
    {
        $query->whereIn('closed_transactions.login', $logins);
    }

    public function date(Builder $query, string $date): void
    {
        $date = Carbon::parse($date);
        $query->whereYear('closed_transactions.created_at', $date->year);
        $query->whereMonth('closed_transactions.created_at', $date->month);
    }
}
