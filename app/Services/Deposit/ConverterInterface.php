<?php

namespace App\Services\Deposit;

interface ConverterInterface
{
    public function convert(ConvertableDTO $convertable): float;
}