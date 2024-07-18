<?php

namespace App\Modules\FilterManager\Search;

use Illuminate\Contracts\Database\Query\Builder;

trait HasSearchingViaScout
{
    public function search(Builder $query, MakeSearchingDTO $searchable): void
    {
        $query->seach($searchable->search);
    }
}
