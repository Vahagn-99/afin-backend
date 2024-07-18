<?php

namespace App\Repositories\Core;

use App\DTO\PaginationDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface PaginatableWithFilter
{
    public function paginateWithFilter(PaginationDTO $paginationDTO): LengthAwarePaginator;
}