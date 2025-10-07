<?php

namespace Multicoin\Api;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Client\Common\Plugin\QueryDefaultsPlugin;
use Http\Message\Authentication\Bearer;
use InvalidArgumentException;
use Multicoin\Api\Service\ApiClient;
use Multicoin\Api\Traits\Address;
use Multicoin\Api\Traits\Currency;
use Multicoin\Api\Traits\Invoice;
use Multicoin\Api\Traits\Transaction;
use Multicoin\Api\Traits\User;

class Multicoin
{
    use Address;
    use Invoice;
    use Transaction;
    use User;
    use Currency;

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
    }

    public function setClient()
    {
        // Basic validation for required keys before creating the ApiClient
        if (empty($this->config['api_token']) || ! is_string($this->config['api_token'])) {
            throw new InvalidArgumentException('Invalid configuration: "api_token" is missing or empty.');
        }
        if (empty($this->config['url']) || ! is_string($this->config['url'])) {
            throw new InvalidArgumentException('Invalid configuration: "url" is missing or empty.');
        }

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
