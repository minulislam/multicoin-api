<?php

namespace Multicoin\Api\Service;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Http\Discovery\HttpClientDiscovery;
use Psr\Http\Message\ResponseInterface;
use Http\Discovery\MessageFactoryDiscovery;

/**
 * Base class for http based services.
 *
 *
 */
abstract class HttpService
{
    protected $baseUrl;

    private $httpClient;

    private $requestFactory;

    protected $options = [];

    protected $apiKey;
    /**
     * @param HttpClient|null                    $httpClient
     * @param RequestFactory|null|MessageFactory $requestFactory
     * @param array                              $options
     */
    public function __construct(HttpClient $httpClient = null, RequestFactory $requestFactory = null, array $options = [])
    {
        $this->httpClient     = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
        $this->processOptions($options);
        $this->options = $options;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    public function setBaseUrl(string $url)
    {
        $this->baseUrl = $url;
        return $this;
    }
    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function setApiKey(string $key)
    {
        $this->apiKey = $key;
        return $this;
    }

    public function processOptions(array &$options): void
    {
    }

    private function buildRequest($url, array $headers = []): RequestInterface
    {
        return $this->requestFactory->createRequest('GET', $url, $headers);
    }

    protected function request($url, array $headers = []): string
    {
        //  $data = json_decode($response->getBody()->getContents(), true);
        return $this->getResponse($url, $headers)->getBody()->__toString();
        //  return $this->getResponse($url, $headers)->getBody()->getContents()->__toString();
    }

    protected function getResponse($url, array $headers = []): ResponseInterface
    {
        return $this->httpClient->sendRequest($this->buildRequest($url, $headers));
    }
}
