<?php
namespace Multicoin\Api\Service;

use Exception;
use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
// ... existing code ...
use Http\Discovery\Psr17FactoryDiscovery;
use Illuminate\Support\Collection;
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
        string                 $baseUrl,
        array                  $plugins = [],
        bool                   $replace = true,
        ?HttpClient            $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null
    )
    {
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory  = Psr17FactoryDiscovery::findStreamFactory();
        $this->httpClient     = $httpClient ?: HttpClientDiscovery::find();
        $this->baseUriPlugin  = new BaseUriPlugin(
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
     * @param string $method get|post|put|delete...
     * @param string $url
     * @param array  $data
     *
     * @return Collection
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
            throw new Exception(
                sprintf('HTTP client error during %s %s: %s', strtoupper($method), $url, $exception->getMessage()),
                (int) $exception->getCode(),
                $exception
            );
        }

    }

    protected function parseJson(string $response): Collection
    {
        $data = json_decode($response, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new Exception('Invalid JSON response: ' . json_last_error_msg());
        }

        return new Collection($data ?? []);
        // Return a plain array to avoid JSON-serializing Illuminate\Support\Collection on PHP 8.1
        return is_array($data) ? $data : [];

    }
}
