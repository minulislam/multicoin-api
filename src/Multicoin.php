<?php

namespace Multicoin\Api;

use Multicoin\Api\Traits\User;
use Multicoin\Api\Traits\Address;
use Multicoin\Api\Traits\Invoice;
use Multicoin\Api\Traits\Currency;
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
    use User, Currency;

    public $coin;

    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->coin = $config['coin'];
        $this->setAuth($this->config['key']);
        parent::__construct($this->config['url']);
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

    public function buildUrl($url)
    {
        return '/'.trim($this->coin, '/').$url;
    }

    public function buildQueryParam(array $default, array $param = [])
    {
        //$data = array_filter(array_merge($default, $param), 'strlen');
        $params = array_merge($default, $param);

        return http_build_query($params);
    }
}
