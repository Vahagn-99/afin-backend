<?php

namespace App\Repositories\ManagerBonus;

use App\DTO\FindBonusDTO;
use App\DTO\CalculatedManagerBonusDTO;
use App\Models\ManagerBonus;
use App\Modules\FilterManager\Filter\FiltersAggregor;
use App\Repositories\Core\PaginatableWithFilter;
use App\Repositories\Core\Relational;

interface ManagerBonusRepositoryInterface extends Relational
{
    public function save(CalculatedManagerBonusDTO $saveManagerBonusDTO): array;

    public function getBy(FindBonusDTO $findBonusDTO): ManagerBonus;

    public function getAll(FiltersAggregor $filters): array;
}