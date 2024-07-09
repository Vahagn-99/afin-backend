<?php

namespace App\Modules\PaginatorManager;

use App\DTO\PaginationDTO;
use Illuminate\Pagination\AbstractPaginator;

interface PaginatorInterface
{
    public function paginate(array $items, PaginationDTO $paginationDTO): AbstractPaginator;
}