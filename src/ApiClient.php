<?php

namespace Multicoin\Api;

use Http\Message\UriFactory;
use Http\Message\RequestFactory;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Client\Common\Plugin\BaseUriPlugin;

class ApiClient
{
    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var HttpClient
     */
    private $httpClient;
    /**
     * @var UriFactory
     */
    private $uriFactory;

    public function __construct(HttpClient $httpClient = null, RequestFactory $requestFactory = null)
    {
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        //$this->httpClient     = $httpClient ?: HttpClientDiscovery::find();
        //      $this->uriFactory     = $uriFactory ?: UriFactoryDiscovery::find();
        $this->uriFactory = new BaseUriPlugin(UriFactoryDiscovery::find()->createUri('https://httpbin.org'));

        $this->httpClient = new PluginClient(
            $httpClient ?: HttpClientDiscovery::find(),
            [$this->uriFactory]
        );

    }
    public function doStuff()
    {
        $request  = $this->requestFactory->createRequest('GET', 'headers');
        $response = $this->httpClient->sendRequest($request);
        //  $result   = $this->httpClient->sendRequest($request);
        var_dump($response);
        return $response->getBody();

    }
}
