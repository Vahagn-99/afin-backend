<?php

namespace App\Repositories\Transaction;

use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Modules\JsonManager\Json;

class JsonTransactionRepository implements FileSystemTransactionRepositoryInterface
{


    public function getAll(?FiltersAggregator $aggregator = null): array
    {
        return Json::all();
    }

    public function getTransactionsByJsonFilePath($path): array
    {
        return Json::get($path)->toArray();
    }
}