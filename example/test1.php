<?php

require './vendor/autoload.php';

use Multicoin\Api\Multicoin;
use Multicoin\Api\Facade\Multicoin as MulticoinFacade;


$config = [
   // 'api_token'   => '',
    'api_token' => '',
    'url'   => 'http://multicoin-backend.test/api/v1/',
    'coin'  => 'BTC',

];


$api     = new Multicoin($config);

dump($api->currency());
dd($api->fee());
//$invoice = $api->createInvoice(['user_id' => 1]);


 dump($invoice);





$facade = get_class_methods(MulticoinFacade::class);
var_export($facade);
$class = get_class_methods(Multicoin::class);

var_export($class);
