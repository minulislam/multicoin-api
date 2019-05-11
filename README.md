# Very short description of the package

[![StyleCI](https://github.styleci.io/repos/166758762/shield?branch=develop)](https://github.styleci.io/repos/166758762)
 [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/minulislam/multicoin-api/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/minulislam/multicoin-api/?branch=develop)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/minulislam/multicoin-api/badges/code-intelligence.svg?b=develop)](https://scrutinizer-ci.com/code-intelligence)
[![Build Status](https://scrutinizer-ci.com/g/minulislam/multicoin-api/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/minulislam/multicoin-api/build-status/develop)

 

 
 
``` php
<?php

require './vendor/autoload.php';
use Multicoin\Api\Multicoin;
$config = [
    'key'   => 'apikey',
    'token' => 'apitoken',
    'url'   => 'http://apiendpoint/api/v1/',
    'coin'  => 'TBTC',

];
$address = 'currencyAddress';
$txid    = 'TransactionID';

$api     = new Multicoin($config);


$invoice = $api->createInvoice(['user_id' => 1]);
d($invoice);

$addressNew = $api->addressNew();
 

$addressInfo = $api->address($address);
 

$addressBalance = $api->addressBalance($address);
 

$addressTxs = $api->addressTxs($address);
 
 

$addressValidate = $api->addressValidate($address);
 

$unpaidInvoice = $api->unpaidInvoice();
 

$paidInvoice = $api->paidInvoice();
 

$transaction = $api->transaction($txid);
 

$transactionValidate = $api->transactionValidate($txid);
 

$transactionConfirmations = $api->transactionConfirmations($txid);
 

$coreBalance = $api->coreBalance();
 

$balance = $api->balance();
 

$info = $api->info();
 

$currency = $api->currency('TBTC');
 

$activeCurrencys = $api->activeCurrencys();



### Testing

``` bash
composer test
```
    "require": {
        "php": "^7.1.3",
        "php-http/httplug": "^1.0 || ^2.0",
        "php-http/discovery": "^1.4",
        "php-http/message-factory": "^1.0.2",
        "php-http/client-implementation": "^1.0",
        "psr/simple-cache": "^1.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^7.5",
        "php-http/message": "^1.0",
        "php-http/mock-client": "^1.0",
        "nyholm/psr7": "^0.2.2"
    },
### Changelog
 
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed  
