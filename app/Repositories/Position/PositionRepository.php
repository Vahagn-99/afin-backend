<?php

namespace App\Repositories\Position;

use App\DTO\PaginationDTO;
use App\Models\Position;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PositionRepository extends RepositoryFather implements PositionRepositoryInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = Position::query();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO, ?FiltersAggregor $filters = null): LengthAwarePaginator
    {
        return $this->getQuery()
            ->filter($filters)
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page
            );
    }

    public function getAll(?FiltersAggregor $aggregator = null): array
    {
        return $this->getQuery()
            ->filter($aggregator)
            ->get()
            ->toArray();
    }

    public function truncate(): void
    {
        DB::table('positions')->truncate();
    }

}