<?php

namespace App\Modules\FilterManager\Search;

use App\Modules\FilterManager\Filter\FilterInterface;
use Illuminate\Contracts\Database\Query\Builder;

interface Searchable extends FilterInterface
{
    public function search(Builder $query, MakeSearchingDTO $dto): void;
}
