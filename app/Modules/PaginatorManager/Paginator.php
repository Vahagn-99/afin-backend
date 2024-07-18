<?php

namespace App\Modules\PaginatorManager;

use App\DTO\PaginationDTO;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Facade;

/**
 * @method static AbstractPaginator paginate(array $data, PaginationDTO $paginationDTO)
 * @mixin PaginatorInterface
 */
class Paginator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'custom_paginator';
    }
}