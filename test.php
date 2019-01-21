<?php

require './vendor/autoload.php';
use Multicoin\Api\Multicoin;

$config = [
    'key'   => 'DxjEMVbXapaRImw',
    'token' => 'DxjEMVbXapaRImw',
    'url'   => 'http://multicoin.l4zym1nd.net/api/v1/',
    'coin'  => 'TBTC',

];

$api = new Multicoin($config);
$user = $api->createInvoice(['user_id' => 1]);
dd($user->code);
//echo '<pre>'.print_r($user->getBody()->getContents(), true).'</pre>';
