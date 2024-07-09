<?php

namespace App\Modules\FilterManager;

use Illuminate\Contracts\Database\Query\Builder;
use App\Modules\FilterManager\Compare\Comparable;
use App\Modules\FilterManager\Filter\FilterableDTO;
use App\Modules\FilterManager\Filter\FilterInterface;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Modules\FilterManager\Interfaces\FilterManagerInterface;
use App\Modules\FilterManager\Search\Searchable;
use App\Modules\FilterManager\Search\MakeSearchingDTO;
use App\Modules\FilterManager\Sort\Sortable;
use Illuminate\Support\Str;

class FilterManager implements FilterManagerInterface
{
    private FilterInterface $filter;

    public function apply(Builder $query, FilterInterface $filter, FiltersAggregator $filters): Builder
    {
        $this->filter = $filter;
        $this->useFilters($query, $filters->getFilterables());
        $this->useSorts($query, $filters->getSortables());
        $this->useCompare($query, $filters->getComparables());
        $this->useSearch($query, $filters->getSearchable());

        return $query;
    }

    private function useFilters(Builder $query, array $filters): void
    {
        /** @var FilterableDTO $filterDTO */
        foreach ($filters as $filterDTO) {
            $filter = $this->toCamelCase($filterDTO->field);
            if ($this->filterExist($filter)) {
                $this->filter->{$filter}($query, $filterDTO->value);
            }
        }
    }

    private function useSearch(Builder $query, ?MakeSearchingDTO $searchable): void
    {
        if ($this->filter instanceof Searchable && $searchable) {
            $this->filter->search($query, $searchable);
        }
    }

    private function useSorts(Builder $query, array $sortables): void
    {
        if ($this->filter instanceof Sortable) {
            foreach ($sortables as $sortable) {
                $method = $this->toCamelCase('sort' . ucfirst($sortable->attribute));
                if (method_exists($this->filter, $method)) {
                    $this->filter->{$method}($query, $sortable);
                } else {
                    $this->filter->sort($query, $sortable);
                }
            }
        }
    }

    private function useCompare(Builder $query, array $compares): void
    {
        if ($this->filter instanceof Comparable) {
            foreach ($compares as $compareDTO) {
                $method = $this->toCamelCase('compare' . ucfirst($compareDTO->field));
                if (method_exists($this->filter, $method)) {
                    $this->filter->{$method}($query, $compareDTO);
                } else {
                    $this->filter->compare($query, $compareDTO);
                }
            }
        }
    }

    private function toCamelCase(string $name): string
    {
        return Str::camel($name);
    }

    private function filterExist(string $filter): bool
    {
        return method_exists($this->filter, $filter);
    }
}