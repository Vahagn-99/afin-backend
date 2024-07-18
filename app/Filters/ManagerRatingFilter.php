<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ManagerRatingFilter implements \App\Modules\FilterManager\Filter\FilterInterface
{
    

    public function example(Builder $query, $value): void
    {
        $query->where('you column', $value);
    }
}
