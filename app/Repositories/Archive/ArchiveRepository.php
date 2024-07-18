<?php

namespace App\Repositories\Archive;

use App\DTO\PaginationDTO;
use App\DTO\SaveArchiveDTO;
use App\Models\Archive;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\RepositoryFather;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ArchiveRepository extends RepositoryFather implements ArchiveRepositoryInterface
{
    protected function setQuery(): void
    {
        $this->query = Archive::query();
    }

    public function getAll(?FiltersAggregor $filtersAggregator = null): array
    {
        return $this->getQuery()->filter($filtersAggregator)
            ->get()
            ->toArray();
    }

    public function get(int $id): array
    {
        return $this->getQuery()->find($id)->toArray();
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

    public function save(SaveArchiveDTO $dto): int
    {
        $archive = $this->getQuery()->updateOrCreate(
            ['closet_at' => Carbon::create($dto->closet_at)->format('Y-m-d')],
            [
                'from' => $dto->from,
                'to' => $dto->to,
            ]);
        return $archive->getKey();
    }

    public function getArchiveIdByDate(string $closedDate): int
    {
        $date = Carbon::create($closedDate);
        return $this->getQuery()
            ->whereYear('closet_at', $date->year)
            ->whereMonth('closet_at', $date->month)
            ->first()
            ->getKey();
    }
}