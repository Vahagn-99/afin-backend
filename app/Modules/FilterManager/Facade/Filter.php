<?php

namespace App\Modules\FilterManager\Facade;

use App\Modules\FilterManager\Exceptions\FilterInterfaceException;
use App\Modules\FilterManager\Filter\FilterInterface;
use App\Modules\FilterManager\Filter\FiltersAggregator;
use App\Modules\FilterManager\Interfaces\FilterManagerInterface;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Builder apply(Builder $query, FilterInterface $filter, FiltersAggregator $aggregator)
 *
 * @see  FilterManagerInterface
 */
class Filter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'filter';
    }

    /**
     * Apply filters to a model's query.
     *
     * @param string|object $model
     * @param FiltersAggregator $filtersAggregator
     * @return Builder
     * @throws FilterInterfaceException
     */
    public static function model(string|object $model, FiltersAggregator $filtersAggregator): Builder
    {
        // Retrieve the model instance if a class name is provided
        $model = is_string($model) ? app($model) : $model;

        // Ensure the model has the necessary method
        if (!method_exists($model, 'getFilterAutomatically')) {
            throw new InvalidArgumentException('Model does not have getFilterAutomatically method.');
        }

        // Retrieve the filter from the model
        $filter = $model->getFilterAutomatically();

        // Ensure the filter implements the correct interface
        if (!$filter instanceof FilterInterface) {
            throw new InvalidArgumentException('Filter does not implement FilterInterface.');
        }

        // Apply the filter to the model's query
        return static::apply($model->query(), $filter, $filtersAggregator);
    }

}