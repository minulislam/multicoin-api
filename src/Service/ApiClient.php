<?php

namespace Multicoin\Api\Service;

use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\UriFactory;
use Illuminate\Support\Collection;

class ApiClient
{
    /**
     * @var HttpClient
     */
    protected $httpClient;
    protected $client;
    protected $plugins = [];
    /**
     * @var RequestFactory
     */
    private $requestFactory;

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
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();

        $this->uriFactory = new BaseUriPlugin(UriFactoryDiscovery::find()->createUri($baseUrl), ['replace' => $replace]);
        $this->addPlugins(array_merge($plugins, [$this->uriFactory]));

        $this->client = $this->getHttpClient();
    }

    public function addPlugins($plugin)
    {
        $this->plugins = array_merge($this->plugins, $plugin);
        $this->client = $this->getHttpClient();

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

    public function doGet(string $url):  ?Collection
    {
        try {
            $request = $this->client->get($url);
            $response = $request->getBody()->getContents();
        } catch (ClientErrorException $e) {
            throw new \Exception($e->getMessage()." Error Processing Request for [$url]", 1);

            return collect([
                'code'   => $e->getCode(),
                'reason' => $e->getMessage(),
            ]);
        }

        return $this->responseResult($response);
    }

    public function doPost(string $url, array $data = []) :  ?array
    {
        $request = $this->client->post($url, $data);
        $response = $request->getBody()->getContents();

        return $this->responseResult($response);
    }

    protected function responseResult(?string $response) :  ?Collection
    {
        $data = json_decode($response, true);

        if (isset($data['error'])) {
            throw new \Exception($data['error']['message']);
        }

        return collect($data);
    }
}
