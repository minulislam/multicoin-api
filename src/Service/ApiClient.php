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
use Multicoin\Api\Exceptions\RequestFailedException;
use Http\Client\Common\Exception\ClientErrorException;

class ApiClient
{
    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var HttpClient
     */
    protected $httpClient;
    protected $client;
    protected $plugins = [];

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
        try {
            $request  = $this->client->get($url);
            $response = $request->getBody()->getContents();

        } catch (ClientErrorException $exception) {
            throw new RequestFailedException($exception);
        }

        return $this->responseResult($response);
    }

    public function doPost(string $url, array $data = []) :  ? array
    {
        $request  = $this->client->post($url, $data);
        $response = $request->getBody()->getContents();

        return $this->responseResult($response);

    }

    protected function responseResult($response)
    {
        $data = json_decode($response, true);
        return collect($data);

    }

    protected function checkForErrorsInResponse($response, $json)
    {
        $is_bad_status_code = ($response->status_code >= 400 && $response->status_code < 600);
        $error_message      = null;
        $error_code         = 1;

        if ($json) {
// check for error
            if (isset($json['error'])) {
                $error_message = $json['error'];
            } elseif (isset($json['errors'])) {
                $error_message = isset($json['message']) ? $json['message'] : (is_array($json['errors']) ? implode(', ', $json['errors']) : $json['errors']);
            }

        }

        if ($is_bad_status_code) {
            if (null === $error_message) {
                $error_message = "Received bad status code: {$response->status_code}";
            }

            $error_code = $response->status_code;
        }

// for any errors, throw an exception
        if (null !== $error_message) {
            throw new APIException($error_message, $error_code);
        }

    }

}
