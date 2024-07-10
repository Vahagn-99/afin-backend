<?php

namespace App\Repositories\History;

use App\DTO\PaginationDTO;
use App\DTO\SaveTransactionHistoryDTO;
use App\Models\History;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionHistoryRepository implements TransactionHistoryPaginatedRepositoryInterface
{
    public function getAll(?FiltersAggregator $filtersAggregator = null): array
    {
        return History::filter($filtersAggregator)
            ->get()
            ->toArray();
    }

    public function get(int $id): array
    {
        return History::query()->find($id)->toArray();
    }

    public function paginated(PaginationDTO $paginationDTO, ?FiltersAggregator $filtersAggregator = null): LengthAwarePaginator
    {
        return History::filter($filtersAggregator)->paginate(
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