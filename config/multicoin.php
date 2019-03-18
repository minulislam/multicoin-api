<?php

return [
    'key'             => 'DxjEMVbXapaRImw',
    'secret'   => 'DxjEMVbXapaRImw',
    'url'             => 'http://apiendpoint',
    'path'            => 'multicoin',
    'currency_backup' => [
        'bitcoin'     => 'BTC',
        'bitcoinTest' => 'TBTC',
        'litecoin'    => 'LTC',
    ],
    'currency'        => [
        'BTC',
        'TBTC',
        'LTC',
    ],
    'jobs' => [
    'receive'=>'',
    'send'=>'',
        // 'uptimeCheckFailed' => \App\Jobs\LaravelWebhooks\HandleFailedUptimeCheck::class,
        // 'uptimeCheckRecovered' => \App\Jobs\LaravelWebhooks\HandleRecoveredUptimeCheck::class,
        // ...
    ],
];
