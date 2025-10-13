<?php

namespace Multicoin\Api\Service;

use Exception;
use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Common\Exception\ServerErrorException;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
// ... existing code ...
use Http\Discovery\Psr17FactoryDiscovery;
use Illuminate\Support\Collection;
use Multicoin\Api\Exceptions\RequestFailedException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class ApiClient
{
    protected $client;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    protected $plugins = [];

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    /**
     * Holds the base URI plugin instance.
     *
     * @var BaseUriPlugin
     */
    private $baseUriPlugin;

    public function __construct(
        string $baseUrl,
        array $plugins = [],
        bool $replace = true,
        ?HttpClient $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null
    ) {
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->baseUriPlugin = new BaseUriPlugin(
            Psr17FactoryDiscovery::findUriFactory()->createUri($baseUrl),
            ['replace' => $replace]
        );
        $this->addPlugins(array_merge($plugins, [$this->baseUriPlugin]));
        $this->client = $this->getHttpClient();
    }

    public function addPlugins(array $plugins): self
    {
        $this->plugins = array_merge($this->plugins, $plugins);
        $this->client = $this->getHttpClient();

        return $this;
    }

    public function getHttpClient(): HttpMethodsClient
    {
        return new HttpMethodsClient($this->getPluginClient(), $this->requestFactory, $this->streamFactory);
    }

    public function getPluginClient(): PluginClient
    {
        return new PluginClient($this->httpClient, $this->plugins);
    }

    public function doGet(string $url): Collection
    {
        return $this->executeRequest('get', $url);
    }

    // ... existing code ...
    public function doPost(string $url, array $data = []): Collection
    {
        // Note: $data is passed as headers as per original behavior.
        return $this->executeRequest('post', $url, $data);
    }

    /**
     * Executes an HTTP request and returns parsed JSON as a Laravel Collection.
     *
     * @param  string  $method  get|post|put|delete...
     *
     * @throws Exception
     */
    private function executeRequest(string $method, string $url, array $data = []): Collection
    {
        try {
            // HttpMethodsClient has dynamic methods for verbs.
            $response = $this->client->{$method}($url, $data)->getBody()->getContents();

            return $this->parseJson($response);
        } catch (ClientErrorException $exception) {
            // Re-throw with direct server response included
            throw new RequestFailedException($exception->getRequest(), $exception->getResponse(), $exception);
        } catch (ServerErrorException $exception) {
            // Also handle 5xx errors to expose response body
            throw new RequestFailedException($exception->getRequest(), $exception->getResponse(), $exception);
        }
    }

    protected function parseJson(string $response): Collection
    {
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            //            throw new Exception('Invalid JSON response: ' . json_last_error_msg());
        }

        return new Collection($data ?? []);
    }
}
