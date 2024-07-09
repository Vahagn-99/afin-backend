<?php

namespace App\Http\Resources\Api\V1\Transaction;

use App\Http\Resources\Api\V1\Contact\ContactResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Transaction $resource
 */
class TransactionResourceInRussian extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'Логин' => $this->resource->id,
            'Лк' => $this->resource->lk,
            'Валюта счета (исходная)' => $this->resource->currency,
            'Депозит' => $this->resource->deposit,
            'Отход' => $this->resource->withdrawal,
            'Объем лотов' => $this->resource->volume_lots,
            'Капитал' => $this->resource->equity,
            'Баланс на начало' => $this->resource->balance_start,
            'Баланс на конец' => $this->resource->balance_end,
            'Результат' => $this->resource->commission,
            'Дата создание' => $this->resource->created_at,
            'Клиент' => ContactResource::make($this->whenLoaded('contact')),
        ];
    }
}
