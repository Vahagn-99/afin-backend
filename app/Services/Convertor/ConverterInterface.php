<?php

namespace App\Services\Convertor;

interface ConverterInterface
{
    public function convert(ConvertableDTO $convertable): float;
}