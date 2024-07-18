<?php

namespace App\Imports\Sheets;

use App\Services\Convertor\ConvertableDTO;
use App\Services\Convertor\Converter;

trait HasConvertor
{
    public function convert($amount, $currency): float
    {
        return Converter::convert(new ConvertableDTO($amount, $currency, $this->currencyRates));
    }
}