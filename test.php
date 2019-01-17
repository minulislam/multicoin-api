<?php

require './vendor/autoload.php';
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\HttpAsyncClientDiscovery;
use Http\Client\Common\HttpClientPool\LeastUsedClientPool;

/*$api = new ApiClient();
dd($api->doStuff());*/
$messageFactory = MessageFactoryDiscovery::find();

$httpClient      = HttpClientDiscovery::find();
$httpAsyncClient = HttpAsyncClientDiscovery::find();

$httpClientPool = new LeastUsedClientPool();
$httpClientPool->addHttpClient($httpClient);
$httpClientPool->addHttpClient($httpAsyncClient);

$response = $httpClientPool->sendRequest($messageFactory->createRequest('GET', 'https://httpbin.org/ip'));
$result   = json_decode((string) $response->getBody(), true);
dd($response->getBody()->__toString());

$client = new HttpMethodsClient(
    HttpClientDiscovery::find(),
    MessageFactoryDiscovery::find()
);
