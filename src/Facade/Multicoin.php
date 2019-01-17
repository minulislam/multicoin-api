<?php

namespace Multicoin\Api\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Multicoin\Api\Multicoin
 */
class Multicoin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Multicoin';
    }
}
