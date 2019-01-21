<?php

namespace Multicoin\Api;

use Multicoin\Api\Traits\Address;
use Multicoin\Api\Traits\Invoice;
use Multicoin\Api\Service\ApiClient;
use Multicoin\Api\Traits\Transaction;
use Http\Message\Authentication\Bearer;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;

class Multicoin extends ApiClient
{
    use Address, Invoice, Transaction;

    public $coin;
    private $address;
    private $txid;
    protected $config;
    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->coin   = $config['coin'];
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

        $authentication       = new Bearer($apiKey);
        $authenticationPlugin = new AuthenticationPlugin($authentication);
        $decoderPlugin        = new DecoderPlugin();
        return [$authenticationPlugin, $decoderPlugin];
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
