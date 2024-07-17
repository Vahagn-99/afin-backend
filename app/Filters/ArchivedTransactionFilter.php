<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Modules\FilterManager\Sort\Sortable;
use App\Modules\FilterManager\Sort\HasSorting;
use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Compare\HasComparing;
use Illuminate\Support\Carbon;

class ArchivedTransactionFilter implements Sortable, Comparable
{
    use HasSorting;
    use HasComparing;
    use HasFilterByContact;
    use HasFilterByManagerAcrossContact;

    public function historyId(Builder $query, int $id): void
    {
        $query->where('archived_transactions.archive_id', $id);
    }

    public function lk(Builder $query, int $value): void
    {
        $query->where('archived_transactions.lk', $value);
    }

    public function login(Builder $query, int $value): void
    {
        $query->where('archived_transactions.login', $value);
    }

    public function logins(Builder $query, array $logins): void
    {
        $query->whereIn('archived_transactions.login', $logins);
    }

    public function date(Builder $query, string $date): void
    {
        $date = Carbon::parse($date);
        $query->whereYear('archived_transactions.created_at', $date->year);
        $query->whereMonth('archived_transactions.created_at', $date->month);
    }
}
