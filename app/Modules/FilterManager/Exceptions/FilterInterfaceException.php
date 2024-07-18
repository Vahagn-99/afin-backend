<?php

namespace App\Modules\FilterManager\Exceptions;

use App\Modules\FilterManager\Interfaces\FilterManagerInterface;
use Exception;

class FilterInterfaceException extends Exception
{
    /**
     * @throws FilterInterfaceException
     */
    public static function interfaceNotImplemented()
    {
        throw new  self("The instance not implement the " . FilterManagerInterface::class);
    }
}
