<?php

namespace App\Modules\FilterManager\Mock;

use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Compare\HasComparing;
use App\Modules\FilterManager\Compare\MakeComparingDTO;
use App\Modules\FilterManager\Search\MakeSearchingDTO;
use App\Modules\FilterManager\Search\Searchable;
use App\Modules\FilterManager\Search\HasSearchingViaScout;
use App\Modules\FilterManager\Sort\HasSorting;
use App\Modules\FilterManager\Sort\Sortable;
use App\Modules\FilterManager\Sort\MakeSortingDTO;
use Illuminate\Contracts\Database\Query\Builder;

class OnlyForTestingFilter implements Comparable, Searchable, Sortable
{
    use HasSorting;
    use HasComparing;

    public function name(Builder $query, string $value): void
    {
        $query->where('name', $value);
    }

    public function age(Builder $query, int $value): void
    {
        $query->where('age', $value);
    }

    public function sortCreatedAt(Builder $query, MakeSortingDTO $dto): void
    {
        $query->orderBy('created_at', $dto->direction);
    }

    public function compareSalary(Builder $query, MakeComparingDTO $dto): void
    {
        $query->where('salary', $dto->operator, $dto->value);
    }

    public function search(Builder $query, MakeSearchingDTO $dto): void
    {
        $query->where('salary', "like", "%$dto->search%");
    }
}