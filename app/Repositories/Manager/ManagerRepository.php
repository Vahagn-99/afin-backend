<?php

namespace App\Repositories\Manager;

use App\DTO\PaginationDTO;
use App\DTO\SaveManagerDTO;
use App\Models\Manager;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ManagerRepository extends RepositoryFather implements ManagerRepositoryInterface
{
    protected function setQuery(): void
    {
        $this->query = Manager::query();
    }

    public function save(SaveManagerDTO $managerDTO): array
    {
        $manager = $this->getQuery()->updateOrCreate(
            ['id' => $managerDTO->id],
            [
                'name' => $managerDTO->name,
                'branch' => $managerDTO->branch,
                'type' => $managerDTO->type,
                'avatar' => $managerDTO->avatar,
            ]
        );
        return $manager->toArray();
    }

    public function getAll(?FiltersAggregor $filtersAggregator = null): Collection
    {
        return $this->getQuery()
            ->filter($filtersAggregator)
            ->get();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO, ?FiltersAggregor $filters = null): LengthAwarePaginator
    {
        return $this->getQuery()
            ->filter($filters)
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page,
            );
    }
}