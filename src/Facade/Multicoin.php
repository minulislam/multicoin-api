<?php

namespace Multicoin\Api\Facade;

use \Illuminate\Support\Facades\Facade as Facade;
// use Multicoin\Api\Multicoin as  MulticoinFactory;

class Multicoin extends Facade
{
    protected static function getFacadeAccessor()
    {
       return 'multicoin';
       // return MulticoinFactory::class;
    }
}
