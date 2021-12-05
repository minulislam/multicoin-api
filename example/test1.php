<?php

require './vendor/autoload.php';

use Multicoin\Api\Multicoin;
use Multicoin\Api\Facade\Multicoin as MulticoinFacade;


$config = [
    'key'   => '9345e857-6960-41a4-af8a-6931721309b1',
    'api_token' => '9345e857-692d-4510-a00a-0bd28029cdb9',
    'url'   => 'https://multicoin.dev/api/v1/',
    'coin'  => 'BTC',

];


$api     = new Multicoin($config);


// $invoice = $api->createInvoice(['user_id' => 1]);
$invoice = $api->currencyQuote();
dd($invoice);





$facade = get_class_methods(MulticoinFacade::class);
var_export($facade);
$class = get_class_methods(Multicoin::class);

var_export($class);
