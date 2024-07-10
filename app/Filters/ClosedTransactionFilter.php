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
        $query->where('transactions.lk', $value);
    }

    public function login(Builder $query, int $value): void
    {
        $query->where('transactions.id', $value);
    }

    public function logins(Builder $query, array $logins): void
    {
        $query->whereIn('transactions.id', $logins);
    }

    public function date(Builder $query, string $date): void
    {
        $date = Carbon::parse($date);
        $query->whereYear('transactions.created_at', $date->year);
        $query->whereMonth('transactions.created_at', $date->month);
    }
}
