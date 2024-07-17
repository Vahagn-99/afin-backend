<?php

namespace App\Modules\FilterManager\Filter;

use App\Modules\FilterManager\Compare\MakeComparingDTO;
use App\Modules\FilterManager\Search\MakeSearchingDTO;
use App\Modules\FilterManager\Sort\MakeSortingDTO;
use Illuminate\Support\Arr;

final class FiltersAggregor
{
    private array $filterables = [];
    private array $sortables = [];
    private ?MakeSearchingDTO $searchable = null;
    private array $comparables = [];

    public function addFilter(MakeFilterDTO $dto): self
    {
        $this->filterables[] = $dto;
        return $this;
    }

    public function addComparing(MakeComparingDTO $dto): self
    {
        $this->comparables[] = $dto;
        return $this;
    }

    public function addSorting(MakeSortingDTO $dto): self
    {
        $this->sortables[] = $dto;
        return $this;
    }

    public function addSearching(?MakeSearchingDTO $dto): self
    {
        $this->searchable = $dto;
        return $this;
    }

    public function getFilterables(string $key = null): array|MakeFilterDTO
    {
        if ($key) {
            return Arr::first($this->filterables, fn(MakeFilterDTO $dto) => $dto->field === $key) ?? [];
        }

        return $this->filterables;
    }

    public function getSortables(string $key = null): array|MakeSortingDTO
    {
        if ($key) {
            return Arr::first($this->sortables, fn(MakeSortingDTO $dto) => $dto->attribute === $key) ?? [];
        }

        return $this->sortables;
    }

    public function getComparables(string $key = null): array|MakeComparingDTO
    {
        if ($key) {
            return Arr::first($this->comparables, fn(MakeComparingDTO $dto) => $dto->field === $key) ?? [];
        }

        return $this->comparables;
    }

    public function getSearchable(): ?MakeSearchingDTO
    {
        return $this->searchable;
    }

    public static function forFiltering(MakeFilterDTO $dto): self
    {
        return (new self)->addFilter($dto);
    }

    public static function forSorting(MakeSortingDTO $dto): self
    {
        return (new self)->addSorting($dto);
    }

    public static function forComparing(MakeComparingDTO $dto): self
    {
        return (new self)->addComparing($dto);
    }

    public static function forSearching(MakeSearchingDTO $dto): self
    {
        return (new self)->addSearching($dto);
    }

}