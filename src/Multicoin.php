<?php

namespace Multicoin\Api;

use Multicoin\Api\Traits\Address;
use Multicoin\Api\Traits\Invoice;
use Multicoin\Api\Service\ApiClient;
use Multicoin\Api\Traits\Transaction;
use Http\Message\Authentication\Bearer;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Client\Common\Plugin\QueryDefaultsPlugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;

class Multicoin extends ApiClient
{
    use Address, Invoice, Transaction;

    public $coin;

    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->coin = $config['coin'];
        parent::__construct(
            $this->setUrl($this->config['url']),
            $this->setAuth($this->config['key'])
        );
    }

    public function setAuth($apiKey = null)
    {
        if (null === $apiKey) {
            $apiKey = config('multicoin.key');
        }

        $authentication = new Bearer($apiKey);
        $authenticationPlugin = new AuthenticationPlugin($authentication);
        $decoderPlugin = new DecoderPlugin();
        $headerSetPlugin = new HeaderSetPlugin([

            'Accept' => 'application/json',
        ]);
        $queryDefaultsPlugin = new QueryDefaultsPlugin([
            'currency' => 'btc',
        ]);

        return [
            $authenticationPlugin,
            $decoderPlugin,
            $headerSetPlugin,
            new RetryPlugin(),
            new ErrorPlugin(),
        ];
    }

    public function setUrl($url = null)
    {
        if (null === $url) {
            return config('multicoin.url');
        }

        return $url;
    }

    public function buildUrlParam($url)
    {
        return '/'.trim($this->coin, '/').$url;
    }
}
