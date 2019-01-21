<?php

namespace Multicoin\Api\Service;

use Http\Client\RequestFactory;
use Http\Client\HttpAsyncClient;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\HttpAsyncClientDiscovery;

abstract class HttpServiceAsync
{
    protected $baseUrl = '';

    protected $httpAsyncClient;

    private $requestFactory;

    protected $options = [];

    protected $apiKey;

    /**
     * @param HttpAsyncClient|null $httpAsyncClient
     * @param RequestFactory|null  $requestFactory
     * @param array                $options
     */
    public function __construct(HttpAsyncClient $httpAsyncClient = null, RequestFactory $requestFactory = null, array $options = [])
    {
        $this->httpAsyncClient = $httpAsyncClient ?: HttpAsyncClientDiscovery::find();
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

    private function buildRequest(string $url, array $params = []): RequestInterface
    {
        return $this->requestFactory->createRequest('GET', $url, $params);
    }

    protected function request($url, array $params = [])
    {
        return $this->getResponse($url, $params)->getBody()->__toString();
    }

    protected function getResponse($url, array $params = []): ResponseInterface
    {
        $promise = $this->httpAsyncClient->sendAsyncRequest($this->buildRequest($url, $params));

        return $promise->then(function (ResponseInterface $response) {
            file_put_contents('responses.log', $response->getStatusCode()."\n", FILE_APPEND);

            return $response;
        },
            function (\Exception $exception) {
                throw $exception;
            }
        );
    }
}
