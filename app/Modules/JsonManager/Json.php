<?php

namespace App\Modules\JsonManager;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Str;

/**
 * @method static ArrayableTransactionManagerInterface|ColletionableTransactionManagerInterface get(string $path)
 * @method static array all()
 * @method static string save(array $transactions, string $date)
 *
 * @see   JsonTransactionManagerInterface
 * @mixin ArrayableTransactionManagerInterface
 * @mixin ColletionableTransactionManagerInterface
 */
class Json extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'JsonManager';
    }

    public static function nameFromPath(string $path): string
    {
        return implode(' ', array_reverse(Str::ucsplit(Str::camel(Str::beforeLast($path, '_transactions.json')))));
    }
}