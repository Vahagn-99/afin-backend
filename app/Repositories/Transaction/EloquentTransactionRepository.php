<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use Illuminate\Support\Facades\DB;

class EloquentTransactionRepository implements DatabaseTransactionRepositoryInterface
{

    public function getAll(?FiltersAggregator $aggregator = null): array
    {
        return Transaction::filter($aggregator)
            ->get()
            ->toArray();
    }

    public function truncate(): void
    {
        DB::table('transactions')->truncate();
    }
}