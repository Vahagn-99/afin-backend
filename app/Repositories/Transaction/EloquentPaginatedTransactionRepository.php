<?php

namespace App\Repositories\Transaction;

use App\DTO\PaginationDTO;
use App\Models\Transaction;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\DatabasePaginatedTransactionRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPaginatedTransactionRepository implements DatabasePaginatedTransactionRepository
{

    public function getAll(FiltersAggregator $aggregator): array
    {
        return Transaction::filter($aggregator)->get()->toArray();
    }

    public function paginated(FiltersAggregator $filtersAggregator, PaginationDTO $paginationDTO): LengthAwarePaginator
    {
        return Transaction::filter($filtersAggregator)->paginate(
            perPage: $paginationDTO->perPage,
            page: $paginationDTO->page
        );
    }
}