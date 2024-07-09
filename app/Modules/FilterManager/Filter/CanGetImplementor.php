<?php

namespace App\Modules\FilterManager\Filter;

use App\Modules\FilterManager\Exceptions\FilterInterfaceException;
use Illuminate\Support\Facades\App;
use RuntimeException;

trait CanGetImplementor
{
    /**
     * Get filter implementer for the current Model.
     * If $filterImplementer is not defined,
     * try to get by model name and "Filters" prefix.
     * If none of these helps return null.
     *
     * @return FilterInterface
     * @throws FilterInterfaceException
     */
    public function getFilterAutomatically(): FilterInterface
    {
        if (!property_exists($this, 'filter')) {
            throw new RuntimeException("Please provide a filter implementation");
        }

        $filter = App::make($this->filter);

        if (!($filter instanceof FilterInterface)) {
            FilterInterfaceException::interfaceNotImplemented();
        }

        return $filter;
    }
}