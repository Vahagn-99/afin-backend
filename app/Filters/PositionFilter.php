<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Modules\FilterManager\Sort\Sortable;
use App\Modules\FilterManager\Sort\HasSorting;
use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Compare\HasComparing;
use App\Modules\FilterManager\Search\Searchable;
use App\Modules\FilterManager\Search\HasSearchingViaScout;

class PositionFilter implements Sortable, Comparable
{
    use HasSorting, HasComparing;
}
