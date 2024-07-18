<?php

namespace App\Modules\FilterManager\Sort;
use Illuminate\Contracts\Database\Query\Builder;

trait HasSorting
{
    public function sort(Builder $query, MakeSortingDTO $order): void
    {
        $query->orderBy($order->attribute, $order->direction);
    }
}
