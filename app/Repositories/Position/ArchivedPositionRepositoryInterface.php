<?php

namespace App\Repositories\Position;

use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\PaginatableWithFilter;
use App\Repositories\Core\Relational;

interface ArchivedPositionRepositoryInterface extends PaginatableWithFilter, Relational
{
    public function getAll(?FiltersAggregor $aggregator = null): array;

    public function saveBatchByArchiveId(int $archiveId, array $positions);
}