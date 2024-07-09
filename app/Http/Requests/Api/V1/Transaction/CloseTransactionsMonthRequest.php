<?php

namespace App\Http\Requests\Api\V1\Transaction;

use App\DTO\CloseTransactionsMonthDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class CloseTransactionsMonthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'month' => ['nullable', 'date'],
        ];
    }

    public function toDTO(): CloseTransactionsMonthDTO
    {
        return new CloseTransactionsMonthDTO(
            Arr::get($this->validated(), 'month', now()->endOfMonth()->format("Y-m"))
        );
    }
}
