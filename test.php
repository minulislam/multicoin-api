<?php

require './vendor/autoload.php';
use Multicoin\Api\ApiClient;
use Http\Message\Authentication\Bearer;
use Http\Client\Common\Plugin\AuthenticationPlugin;

$authentication       = new Bearer('DxjEMVbXapaRImw');
$authenticationPlugin = new AuthenticationPlugin($authentication);

$api = new ApiClient('http://multicoin.test/api/v1', [$authenticationPlugin]);
$api->addPlugins([$authenticationPlugin]);
dd($api->doGet('/user'));

/*$messageFactory = MessageFactoryDiscovery::find();

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
*/
