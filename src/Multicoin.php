<?php

namespace Multicoin\Api;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Client\Common\Plugin\QueryDefaultsPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Message\Authentication\Bearer;
use Multicoin\Api\Service\ApiClient;
use Multicoin\Api\Traits\Address;
use Multicoin\Api\Traits\Currency;
use Multicoin\Api\Traits\Invoice;
use Multicoin\Api\Traits\Transaction;
use Multicoin\Api\Traits\User;

class Multicoin
{
    use Address, Invoice, Transaction;
    use User, Currency;

    public $coin;
    protected $client;

    protected $config;

    public function __construct(array $config = [], $client = null)
    {
        $this->config = $config;
        $this->coin = $config['coin'];
        $this->client = $client ?: $this->setClient();
        //   $this->setAuth($this->config['key']);
     //   parent::__construct($this->setUrl($this->config['url']));
    }

    public function buildQueryParam(array $default, array $param = [])
    {
        //$data = array_filter(array_merge($default, $param), 'strlen');
        $params = array_merge($default, $param);

        return http_build_query($params);
    }

    public function buildUrl($url)
    {
        return '/'.trim($this->coin, '/').$url;
    }

    public function setAuth($apiKey = null)
    {
        if (null === $apiKey) {
            $apiKey = config('multicoin.api_token');
        }

        $authentication = new Bearer($apiKey);
        $authenticationPlugin = new AuthenticationPlugin($authentication);

        return $authenticationPlugin;

        return [
            $authenticationPlugin,
        ];
    }

    public function setClient()
    {
        $plugins = $this->setPlugins($this->config['api_token']);
        $baseUrl = $this->setUrl($this->config['url']);

        return new ApiClient($baseUrl, $plugins);
    }

    public function setPlugins($apiKey = null)
    {
        $auth = $this->setAuth($apiKey);
        $decoderPlugin = new DecoderPlugin();
        $headerSetPlugin = new HeaderSetPlugin([
            'Accept' => 'application/json',
        ]);
        $queryDefaultsPlugin = new QueryDefaultsPlugin([
            'currency' => 'btc',
        ]);

        return [
            $auth,
            $decoderPlugin,
            $headerSetPlugin,
            $queryDefaultsPlugin,
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
}
