<?php

namespace Multicoin\Api\Facade;

use Illuminate\Support\Facades\Facade;

class Multicoin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'multicoin';
    }
}
