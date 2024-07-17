<?php

namespace App\Repositories\Manager;

use App\DTO\SaveContactDTO;
use App\DTO\SaveManagerDTO;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\PaginatableWithFilter;
use Illuminate\Database\Eloquent\Collection;

interface ManagerRepositoryInterface extends PaginatableWithFilter
{
    public function save(SaveManagerDTO $managerDTO): array;

    public function getAll(?FiltersAggregor $filtersAggregator = null): Collection;
}