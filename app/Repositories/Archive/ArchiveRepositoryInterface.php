<?php

namespace App\Repositories\Archive;

use App\DTO\SaveArchiveDTO;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\PaginatableWithFilter;

interface ArchiveRepositoryInterface extends PaginatableWithFilter
{
    public function getAll(?FiltersAggregor $filtersAggregator = null): array;

    public function get(int $id): array;

    public function save(SaveArchiveDTO $dto): int;

    public function getArchiveIdByDate(string $closedDate): int;
}