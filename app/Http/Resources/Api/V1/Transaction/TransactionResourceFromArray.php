<?php

namespace App\Http\Resources\Api\V1\Transaction;

use App\Http\Resources\Api\V1\Contact\ContactResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/**
 * @property array $resource
 */
class TransactionResourceFromArray extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'login' => Arr::get($this->resource, 'login', Arr::get($this->resource, 'id')),
            'lk' => Arr::get($this->resource, 'lk'),
            'currency' => Arr::get($this->resource, 'currency'),
            'deposit' => Arr::get($this->resource, 'deposit'),
            'withdrawal' => Arr::get($this->resource, 'withdrawal'),
            'volume_lots' => Arr::get($this->resource, 'volume_lots'),
            'equity' => Arr::get($this->resource, 'equity'),
            'balance_start' => Arr::get($this->resource, 'balance_start'),
            'balance_end' => Arr::get($this->resource, 'balance_end'),
            'commission' => Arr::get($this->resource, 'commission'),
            'created_at' => Arr::get($this->resource, 'created_at'),
            'contact_id' => Arr::get($this->resource, 'contact_id')
        ];
    }
}
