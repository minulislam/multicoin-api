<?php

require './vendor/autoload.php';

use Multicoin\Api\Multicoin;
use Multicoin\Api\Facade\Multicoin as MulticoinFacade;


$config = [
    'key'   => '955e36d2-e91e-4ac1-b29b-d54895024579',
    'api_token' => '955e36d2-e8a2-4845-bc7c-40c2559f984c',
    'url'   => 'http://multicoin-backend.test/api/v1/',
    'coin'  => 'BTC',

];


$api     = new Multicoin($config);


//$invoice = $api->createInvoice(['user_id' => 1]);
//$invoice = $api->currencyQuote();
$invoice = $api->withdraw(['address'=>'bc1qxmud50pt7h58eu9m2y9y9rhf90y3je70ldp6nn','amount'=>0.001]);

 dump($invoice);





$facade = get_class_methods(MulticoinFacade::class);
var_export($facade);
$class = get_class_methods(Multicoin::class);

var_export($class);
