<?php

namespace App\Modules\PaginatorManager;

use App\DTO\PaginationDTO;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ArrayPaginator implements PaginatorInterface
{
    public function paginate(array $items, PaginationDTO $paginationDTO): LengthAwarePaginator
    {
        $page = $paginationDTO->page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $paginationDTO->perPage), $items->count(), $paginationDTO->perPage, $page, $paginationDTO->options);
    }
}