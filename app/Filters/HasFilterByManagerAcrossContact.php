<?php

namespace App\Filters;

use App\Modules\FilterManager\Sort\MakeSortingDTO;
use Illuminate\Database\Eloquent\Builder;

trait HasFilterByManagerAcrossContact
{
    public function managerName(Builder $query, string $value): void
    {
        $query->whereHas('contact', function (Builder $query) use ($value) {
            $query->whereHas('manager', function (Builder $query) use ($value) {
                $query->where('managers.name', $value);
            });
        });
    }

    public function managerId(Builder $query, string $value): void
    {
        $query->whereHas('contact', function (Builder $query) use ($value) {
            $query->whereHas('manager', function (Builder $query) use ($value) {
                $query->where('managers.id', $value);
            });
        });
    }

    public function managerBranch(Builder $query, string $value): void
    {
        $query->whereHas('contact', function (Builder $query) use ($value) {
            $query->whereHas('manager', function (Builder $query) use ($value) {
                $query->where('managers.branch', $value);
            });
        });
    }

    public function sortManagerName(Builder $query, MakeSortingDTO $sortingDTO): void
    {
        $table = $query->getModel()->getTable();
        $query->orderBy(function (\Illuminate\Database\Query\Builder $q) use ($table) {
            return $q->from('contacts')
                ->join('managers', 'contacts.manager_id', '=', 'managers.id')
                ->whereRaw('contacts.login = ' . $table . '.login')
                ->select('managers.name');
        }, $sortingDTO->direction);
    }
    public function sortManagerBranch(Builder $query, MakeSortingDTO $sortingDTO): void
    {
        $table = $query->getModel()->getTable();
        $query->orderBy(function (\Illuminate\Database\Query\Builder $q) use ($table) {
            return $q->from('contacts')
                ->join('managers', 'contacts.manager_id', '=', 'managers.id')
                ->whereRaw('contacts.login = ' . $table . '.login')
                ->select('managers.branch');
        }, $sortingDTO->direction);
    }
}