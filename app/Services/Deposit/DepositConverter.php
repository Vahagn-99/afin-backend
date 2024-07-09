<?php

namespace App\Services\Deposit;

use App\Enums\Currency;
use Illuminate\Support\Str;

class DepositConverter implements ConverterInterface
{
    public function convert(ConvertableDTO $convertable): float
    {
        $deposit = $convertable->amount;

        $priceForUnit = match (Str::upper($convertable->currency)) {
            Currency::CNY => $convertable->rates->cny,
            Currency::USD => $convertable->rates->usd,
            Currency::EUR => $convertable->rates->eur,
            Currency::RUB => 1
        };

        return $deposit * $priceForUnit;
    }
}