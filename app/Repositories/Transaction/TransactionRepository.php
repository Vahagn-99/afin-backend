<?php

namespace App\Repositories\Transaction;

use App\DTO\PaginationDTO;
use App\Models\Transaction;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TransactionRepository extends RepositoryFather implements TransactionRepositoryInterface, TransactionDepositCalculateInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = Transaction::query();
    }

    public function getAll(?FiltersAggregor $aggregator = null): array
    {
        return $this->getQuery()
            ->filter($aggregator)
            ->get()
            ->toArray();
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

    public function calculate(?FiltersAggregor $filters = null): array
    {
        return $this->getQuery()
            ->select(['login', DB::raw('sum(deposit) as total')])
            ->filter($filters)
            ->groupBy('login')
            ->get()
            ->pluck('total', 'login')
            ->toArray();
    }

    public function getById(int $id): Transaction
    {
        /** @var Transaction */
        return $this->getQuery()->find($id);
    }

    public function truncate(): void
    {
        DB::table('transactions')->truncate();
    }
}