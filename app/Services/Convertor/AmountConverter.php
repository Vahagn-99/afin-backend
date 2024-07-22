<?php

namespace App\Services\Convertor;

use App\Enums\Currency;
use Exception;
use Illuminate\Support\Str;

class AmountConverter implements ConverterInterface
{
    /**
     * @throws Exception
     */
    public function convert(ConvertableDTO $convertable): float
    {
        $convertor = $convertable->amount;

        if (!$convertor) return 0;

        $priceForUnit = match (Str::upper($convertable->currency)) {
            Currency::CNY => $convertable->rates->cny,
            Currency::USD => $convertable->rates->usd,
            Currency::EUR => $convertable->rates->eur,
            default => 1,
        };

        return round($priceForUnit * $convertor, 2);
    }
}