<?php

namespace App\Filters;

use App\Modules\FilterManager\Search\MakeSearchingDTO;
use App\Modules\FilterManager\Search\Searchable;
use Illuminate\Database\Eloquent\Builder;

class ContactFilter implements Searchable
{
    public function example(Builder $query, $value): void
    {
        $query->where('you column', $value);
    }

    public function search(\Illuminate\Contracts\Database\Query\Builder $query, MakeSearchingDTO $dto): void
    {
        // TODO: Implement search() method.
    }
}
