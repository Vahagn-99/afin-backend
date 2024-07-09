<?php

namespace App\Repositories\Position;

use App\DTO\PaginationDTO;
use App\Models\Position;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Position\PositionPaginatedRepositoryInterface;
use Illuminate\Pagination\AbstractPaginator;

class PositionRepository implements PositionPaginatedRepositoryInterface
{
    public function getAllPaginated(PaginationDTO $paginationDTO, ?FiltersAggregator $aggregator = null): AbstractPaginator
    {
        return Position::filter($aggregator)->paginate(
            perPage: $paginationDTO->perPage,
            page: $paginationDTO->page
        );
    }

    public function getAll(?FiltersAggregator $aggregator = null): array
    {
        return Position::filter($aggregator)->get()->toArray();
    }
}