<?php

require './vendor/autoload.php';

use Multicoin\Api\Multicoin;
use Multicoin\Api\Facade\Multicoin as MulticoinFacade;

$facade =  get_class_methods(MulticoinFacade::class);
var_export($facade);
$class = get_class_methods(Multicoin::class);

var_export($class);
