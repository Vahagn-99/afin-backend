<?php

namespace App\Repositories\Contact;

use App\DTO\SaveContactDTO;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\PaginatableWithFilter;
use App\Repositories\Core\Relational;

interface ContactRepositoryInterface extends PaginatableWithFilter, Relational
{

    public function save(SaveContactDTO $amoContactDTO): array;

    public function getOnly(string $string, FiltersAggregor $filter);

    public function getAll(FiltersAggregor $filter): array;
}