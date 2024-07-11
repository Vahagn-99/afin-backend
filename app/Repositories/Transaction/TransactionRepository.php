<?php

namespace App\Repositories\Transaction;

use App\DTO\PaginationDTO;
use App\Models\Transaction;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\TransactionRepositoryInterface;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository extends RepositoryFather implements TransactionRepositoryInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = Transaction::query();
    }

    public function getAll(FiltersAggregator $aggregator): array
    {
        return $this->getQuery()
            ->filter($aggregator)
            ->get()
            ->toArray();
    }

    public function paginateWithFilter(PaginationDTO $paginationDTO, ?FiltersAggregator $filters= null): LengthAwarePaginator
    {
        return $this->getQuery()
            ->filter($filters)
            ->paginate(
                perPage: $paginationDTO->perPage,
                page: $paginationDTO->page
            );
    }
}