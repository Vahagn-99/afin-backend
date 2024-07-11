<?php

namespace App\Repositories\History;

use App\DTO\PaginationDTO;
use App\DTO\SaveTransactionHistoryDTO;
use App\Models\History;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\RepositoryFather;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionHistoryRepository extends RepositoryFather implements TransactionHistoryRepositoryInterface
{
    protected function setQuery(): void
    {
        $this->query = History::query();
    }

    public function getAll(?FiltersAggregator $filtersAggregator = null): array
    {
        return $this->getQuery()->filter($filtersAggregator)
            ->get()
            ->toArray();
    }

    public function get(int $id): array
    {
        return $this->getQuery()->find($id)->toArray();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO, ?FiltersAggregator $filters = null): LengthAwarePaginator
    {
        return $this->getQuery()
            ->filter($filters)
            ->paginate(
            perPage: $paginationDTO->perPage,
            page: $paginationDTO->page,
        );
    }

    public function save(SaveTransactionHistoryDTO $dto): int
    {
        $history = new History;
        $history->from = $dto->from;
        $history->to = $dto->to;
        $history->closet_at = Carbon::create($dto->closet_at)->format('Y-m');
        $history->save();
        return $history->getKey();
    }
}