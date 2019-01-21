<?php

require './vendor/autoload.php';
use Multicoin\Api\Multicoin;

$config = [
    'key'   => 'DxjEMVbXapaRImw',
    'token' => 'DxjEMVbXapaRImw',
    'url'   => 'http://multicoin.test/api/v1/',
    'coin'  => 'TBTC',

];
$address = 'mpNxCePBFmyouh7oZ1kCuA1rLdFfVgxE9v';
$txid = 'afb9d5ce5adbea5fa0f5cac993ebf8f5806a0c2f9c9caf51eee0edccc75c29c8';
$api = new Multicoin($config);
/*$traits = class_uses_recursive(Multicoin::class);
d($traits);
$classMethod = collect(get_class_methods($api));*/

$method = ['__construct', 'setAuth', 'setUrl', 'buildUrl', 'buildQueryParam',
    'addPlugins', 'getHttpClient', 'getPluginClient', 'doGet', 'doPost',
    'addressNew', 'addressBalance', 'address', 'addressTxs', 'addressUtxo',
    'addressValidate', 'transactionsFromDb', 'transactionsFromApi',
    'createInvoice', 'unpaidInvoice', 'paidInvoice', 'transaction', 'transactionValidate',
    'transactionConfirmations', 'coreBalance', 'balance', 'info',
    'activeCurrencys', 'currency', ];

$invoice = $api->createInvoice(['user_id' => 1]);
d($invoice);

$addressNew = $api->addressNew();
d($addressNew);

$addressInfo = $api->address($address);
d($addressInfo);

$addressBalance = $api->addressBalance($address);
dd($addressBalance);

$addressTxs = $api->addressTxs($address);
d($addressTxs);
/*$addressUtxo = $api->addressUtxo();
d($addressUtxo);*/

$addressValidate = $api->addressValidate($address);
d($addressValidate);

$unpaidInvoice = $api->unpaidInvoice();
d($unpaidInvoice);

$paidInvoice = $api->paidInvoice();
d($paidInvoice);

$transaction = $api->transaction($txid);
d($transaction);

$transactionValidate = $api->transactionValidate($txid);
d($transactionValidate);

$transactionConfirmations = $api->transactionConfirmations($txid);
d($transactionConfirmations);

$coreBalance = $api->coreBalance();
d($coreBalance);

$balance = $api->balance();
d($balance);

$info = $api->info();
d($info);

$currency = $api->currency('TBTC');
d($currency);

$activeCurrencys = $api->activeCurrencys();
d($activeCurrencys);
