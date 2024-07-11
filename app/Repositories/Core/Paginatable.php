<?php

namespace App\Repositories\Core;

use App\DTO\PaginationDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface Paginatable
{
    public function paginated(PaginationDTO $paginationDTO): LengthAwarePaginator;
}