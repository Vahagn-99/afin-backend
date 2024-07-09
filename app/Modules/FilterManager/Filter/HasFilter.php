<?php

namespace App\Modules\FilterManager\Filter;

use App\Modules\FilterManager\Exceptions\FilterInterfaceException;
use App\Modules\FilterManager\Facade\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder filter(FiltersAggregator $filters)
 * @property string $filter
 *
 */
trait HasFilter
{
    use CanGetImplementor;

    /**
     * Applies filters to the query using the provided FiltersAggregator.
     *
     * @param Builder $query
     * @param FiltersAggregator|null $filters
     * @return Builder
     * @throws FilterInterfaceException
     */
    public function scopeFilter(Builder $query, ?FiltersAggregator $filters): Builder
    {
        if (!$filters) return $query;
        return Filter::apply($query, $this->getFilterAutomatically(), $filters);
    }
}
