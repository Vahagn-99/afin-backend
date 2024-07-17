<?php

namespace App\Repositories\ArchivedTransaction;

use App\DTO\PaginationDTO;
use App\Models\ArchivedTransaction;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Modules\FilterManager\Filter\MakeFilterDTO;
use App\Repositories\Core\HasRelations;
use App\Repositories\Core\RepositoryFather;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ArchivedTransactionRepository extends RepositoryFather implements ArchivedTransactionRepositoryInterface, ArchivedTransactionDepositCalculateInterface
{
    use HasRelations;

    protected function setQuery(): void
    {
        $this->query = ArchivedTransaction::query();
    }

    public function getAllByHistoryId(int $historyId, PaginationDTO $paginationDTO, ?FiltersAggregor $aggregator = null): LengthAwarePaginator
    {
        $aggregator = $aggregator ?? new FiltersAggregor();
        $aggregator->addFilter(new MakeFilterDTO('archive_id', $historyId));
        return $this->getQuery()->filter($aggregator)->paginate(
            perPage: $paginationDTO->perPage,
            page: $paginationDTO->page,
        );
    }

    public function saveBatchByArchiveId(int $archivedId, array $transactions): void
    {
        $chunks = array_chunk($transactions, 1000, true);
        foreach ($chunks as $chunk) {
            $transactions = array_map(function (array $transaction) use ($archivedId) {
                $transaction['archive_id'] = $archivedId;
                return $transaction;
            }, $chunk);
            DB::table('archived_transactions')->upsert($transactions, ['login']);
        }
    }

    public function getAll(?FiltersAggregor $aggregator = null): array
    {
        return $this->getQuery()
            ->filter($aggregator)
            ->get()
            ->toArray();
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
}