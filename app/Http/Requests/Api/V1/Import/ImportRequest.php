<?php

namespace App\Http\Requests\Api\V1\Import;

use App\DTO\RateDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ImportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "file" => ["required", "file", "mimes:xlsx", "max:10048"],
            'currencies' => ["required", 'array'],
            'currencies.usd' => ["required", "numeric"],
            'currencies.eur' => ["required", "numeric"],
            'currencies.cny' => ["required", "numeric"],
        ];
    }

    public function currencyDTO(): RateDTO
    {
        return new RateDTO(
            Str::upper($this->validated('currencies.usd')),
            Str::upper($this->validated('currencies.eur')),
            Str::upper($this->validated('currencies.cny'))
        );
    }
}
