<?php

namespace App\Http\Requests\Api\V1\CloseMonth;

use App\DTO\CloseMonthDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class CloseMonthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'month' => ['nullable', 'date'],
        ];
    }

    public function toDTO(): CloseMonthDTO
    {
        return new CloseMonthDTO(
            Arr::get($this->validated(), 'month', now()->endOfMonth()->format("Y-m"))
        );
    }
}
