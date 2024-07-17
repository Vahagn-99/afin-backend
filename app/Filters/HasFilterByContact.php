<?php

namespace App\Filters;

use App\Modules\FilterManager\Sort\MakeSortingDTO;
use Illuminate\Database\Eloquent\Builder;

trait HasFilterByContact
{
    public function analytic(Builder $query, string $value): void
    {
        $query->whereRelation('contact', 'analytic', 'LIKE', "%$value%");
    }

    public function contactName(Builder $query, string $value): void
    {
        $query->whereRelation('contact', 'name', 'LIKE', "%$value%");
    }

    public function contactId(Builder $query, string $value): void
    {
        $query->whereRelation('contact', 'id', $value);
    }

    public function sortContactName(Builder $query, MakeSortingDTO $sortingDTO): void
    {
        $table = $query->getModel()->getTable();
        $query->orderBy(function ($q) use ($table) {
            return $q->from('contacts')
                ->whereRaw('contacts.login = ' . $table . '.login')
                ->select('contacts.name');
        }, $sortingDTO->direction);
    }

    public function sortContactAnalytic(Builder $query, MakeSortingDTO $sortingDTO): void
    {
        $table = $query->getModel()->getTable();
        $query->orderBy(function ($q) use ($table) {
            return $q->from('contacts')
                ->whereRaw('contacts.login = ' . $table . '.login')
                ->select('contacts.analytic');
        }, $sortingDTO->direction);
    }

    public function sortContactId(Builder $query, MakeSortingDTO $sortingDTO): void
    {
        $table = $query->getModel()->getTable();
        $query->orderBy(function ($q) use ($table) {
            return $q->from('contacts')
                ->whereRaw('`contacts`.login = `' . $table . '`.login')
                ->select('contacts.id');
        }, $sortingDTO->direction);
    }
}