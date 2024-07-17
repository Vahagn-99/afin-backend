<?php

namespace App\Services\Convertor;

use App\Enums\Currency;
use Illuminate\Support\Str;

class AmountConverter implements ConverterInterface
{
    public function convert(ConvertableDTO $convertable): float
    {
        $convertor = $convertable->amount;

        $priceForUnit = match (Str::upper($convertable->currency)) {
            Currency::CNY => $convertable->rates->cny,
            Currency::USD => $convertable->rates->usd,
            Currency::EUR => $convertable->rates->eur,
            Currency::RUB => 1
        };

        return $convertor * $priceForUnit;
    }
}