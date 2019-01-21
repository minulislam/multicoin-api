<?php

require './vendor/autoload.php';
use Multicoin\Api\Multicoin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
$config = [
    'key'   => 'DxjEMVbXapaRImw',
    'token' => 'DxjEMVbXapaRImw',
    'url'   => 'http://multicoin.l4zym1nd.net/api/v1/',
    'coin'  => 'TBTC',

];

$api  = new Multicoin($config);
$user = $api->addressNew();
dd($user);
//echo '<pre>'.print_r($user->getBody()->getContents(), true).'</pre>';
