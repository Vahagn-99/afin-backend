<?php

namespace App\Repositories\Transaction;

use App\DTO\PaginationDTO;
use App\Models\ClosedTransaction;
use App\Modules\FilterManager\Filter\FilterableDTO;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ClosedTransactionRepository extends RepositoryFather implements ClosedTransactionRepositoryInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = ClosedTransaction::query();
    }

    public function getAllByHistoryId(int $historyId, PaginationDTO $paginationDTO, ?FiltersAggregator $aggregator = null): LengthAwarePaginator
    {
        $aggregator = $aggregator ?? new FiltersAggregator();
        $aggregator->addFilter(new FilterableDTO('history_id', $historyId));
        return $this->getQuery()->filter($aggregator)->paginate(
            perPage: $paginationDTO->perPage,
            page: $paginationDTO->page,
        );
    }

    public function saveBatchByHistoryId(int $historyId, array $transactions): void
    {
        $transactions = array_map(function (array $transaction) use ($historyId) {
            $transaction['history_id'] = $historyId;
            return $transaction;
        }, $transactions);

        DB::table('closed_transactions')->upsert($transactions, ['login']);
    }
}