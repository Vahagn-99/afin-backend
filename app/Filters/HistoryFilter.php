<?php

namespace App\Filters;

use App\Modules\FilterManager\Sort\Sortable;
use App\Modules\FilterManager\Sort\HasSorting;

class HistoryFilter implements Sortable
{
    use HasSorting;
}
