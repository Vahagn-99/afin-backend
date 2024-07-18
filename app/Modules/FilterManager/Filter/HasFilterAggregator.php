<?php

namespace App\Modules\FilterManager\Filter;

use App\Modules\FilterManager\Compare\MakeComparingDTO;
use App\Modules\FilterManager\Sort\MakeSortingDTO;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait HasFilterAggregator
{

    public function aggregateFilters(): FiltersAggregor
    {
        $data = $this->validated();
        $filters = new FiltersAggregor();

        $filters->addSearching($this->validated('search'));
        foreach (Arr::get($data, 'sorts', []) as $field => $direction) {
            $this->ensureGivenCorrectDirection($direction);
            $filters->addSorting(new MakeSortingDTO($field, $direction));
        }

        foreach (Arr::get($data, 'compares', []) as $field) {
            $filters->addComparing(new MakeComparingDTO($field['field'], $field['operator'], $field['value']));
        }

        foreach (Arr::get($data, 'filters', []) as $field => $value) {
            $filters->addFilter(new MakeFilterDTO($field, $value));
        }

        return $filters;
    }


    public function ensureGivenCorrectDirection(string $direction): void
    {
        if (!in_array(Str::lower($direction), ['asc', 'desc']))
            throw ValidationException::withMessages([
                'direction' => "The direction should be asc or desc."
            ]);

    }
}