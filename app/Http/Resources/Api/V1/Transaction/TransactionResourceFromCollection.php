<?php

namespace App\Http\Resources\Api\V1\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Transaction $resource
 */
class TransactionResourceFromCollection extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'login' => $this->resource->id,
            'lk' => $this->resource->lk,
            'currency' => $this->resource->currency,
            'deposit' => $this->resource->deposit,
            'withdrawal' => $this->resource->withdrawal,
            'volume_lots' => $this->resource->volume_lots,
            'equity' => $this->resource->equity,
            'balance_start' => $this->resource->balance_start,
            'balance_end' => $this->resource->balance_end,
            'commission' => $this->resource->commission,
            'created_at' => $this->resource->created_at,
            'contact_id' => $this->resource->contact_id
        ];
    }
}
