<?php

namespace App\Filters;

use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Compare\HasComparing;
use App\Modules\FilterManager\Sort\HasSorting;
use App\Modules\FilterManager\Sort\MakeSortingDTO;
use App\Modules\FilterManager\Sort\Sortable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class TransactionFilter implements Sortable, Comparable
{
    use HasSorting;
    use HasComparing;
    use HasFilterByContact;
    use HasFilterByManagerAcrossContact;

    public function lk(Builder $query, int $value): void
    {
        $query->where('transactions.lk', $value);
    }

    public function login(Builder $query, int $value): void
    {
        $query->where('transactions.login', $value);
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