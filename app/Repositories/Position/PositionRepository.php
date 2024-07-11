<?php

namespace App\Repositories\Position;

use App\DTO\PaginationDTO;
use App\Models\Position;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;

class PositionRepository extends RepositoryFather implements PositionRepositoryInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = Position::query();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO, ?FiltersAggregator $filters = null): LengthAwarePaginator
    {
        return $this->getQuery()
            ->filter($filters)
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page
            );
    }

    public function getAll(?FiltersAggregator $aggregator = null): array
    {
        return $this->getQuery()
            ->filter($aggregator)
            ->get()
            ->toArray();
    }
}