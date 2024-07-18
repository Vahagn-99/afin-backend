<?php

namespace App\Filters;

use App\Modules\FilterManager\Sort\Sortable;
use App\Modules\FilterManager\Sort\HasSorting;

class ArchiveFilter implements Sortable
{
    use HasSorting;
}
