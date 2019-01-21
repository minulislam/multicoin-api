<?php

namespace Multicoin\Api\Service;

use Http\Client\HttpClient;
use Http\Message\UriFactory;
use Http\Message\RequestFactory;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Client\Common\HttpMethodsClient;
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
    public $client;
    private $plugins = [];

    /**
     * @var UriFactory
     */
    private $uriFactory;

    public function __construct(
        string         $baseUrl,
        array          $plugins = [],
        bool           $replace = true,
        HttpClient     $httpClient = null,
        RequestFactory $requestFactory = null
    ) {
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        $this->httpClient     = $httpClient ?: HttpClientDiscovery::find();

        $this->uriFactory = new BaseUriPlugin(UriFactoryDiscovery::find()->createUri($baseUrl), ['replace' => $replace]);
        $this->addPlugins(array_merge($plugins, [$this->uriFactory]));

        $this->client = $this->getHttpClient();

    }

    public function addPlugins($plugin)
    {
        $this->plugins = array_merge($this->plugins, $plugin);
        $this->client  = $this->getHttpClient();
        return $this;

    }
    public function getHttpClient()
    {
        return new HttpMethodsClient($this->getPluginClient(), $this->requestFactory);

    }

    public function getPluginClient()
    {
        return new PluginClient($this->httpClient, $this->plugins);

    }

    public function doGet(string $url):  ? array
    {
        $response = $this->client->get($url);

        return json_decode($response->getBody()->getContents(), true);

    }
    public function doPost(string $url, array $data = []) :  ? array
    {
        $response = $this->client->get($url, $data);
        return json_decode((string) $response->getBody(), true);

    }

}
