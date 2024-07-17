<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Modules\FilterManager\Sort\Sortable;
use App\Modules\FilterManager\Sort\HasSorting;
use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Compare\HasComparing;
use App\Modules\FilterManager\Search\Searchable;
use App\Modules\FilterManager\Search\HasSearchingViaScout;

class ArchivedPositionFilter implements Sortable, Comparable
{
    use HasSorting;
    use HasComparing;
    use HasFilterByContact;
    use HasFilterByManagerAcrossContact;

    public function historyId(Builder $query, int $id): void
    {
        $query->where('archived_positions.archive_id', $id);
    }

    public function login(Builder $query, $value): void
    {
        $query->where('login', $value);
    }
}
