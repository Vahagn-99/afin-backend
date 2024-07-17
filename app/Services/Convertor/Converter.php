<?php

namespace App\Services\Convertor;

use Illuminate\Support\Facades\Facade;

/**
 * @method static float convert(ConvertableDTO $convertableDTO)
 * @mixin ConverterInterface
 */
class Converter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'currency_converter';
    }
}