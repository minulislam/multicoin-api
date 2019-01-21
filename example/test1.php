<?php

require './vendor/autoload.php';

use Multicoin\Api\Multicoin;
use Multicoin\Api\Facade\MulticoinFacade;

$api = Multicoin::class;
get_class_methods(MulticoinFacade::class);

$class = get_class_methods(Multicoin::class);

var_export($class);
