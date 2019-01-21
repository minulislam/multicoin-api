<?php

namespace Multicoin\Api;

use Multicoin\Api\Traits\Address;
use Multicoin\Api\Traits\Invoice;
use Multicoin\Api\Service\ApiClient;
use Multicoin\Api\Traits\Transaction;
use Http\Message\Authentication\Bearer;
use Http\Client\Common\Plugin\AuthenticationPlugin;

class Multicoin extends ApiClient
{
    use Address, Invoice, Transaction;
    public $apiKey;
    public $url;
    //  public $coin;
    private $address;
    private $txid;
    protected $config;
    public function __construct(array $config = [])
    {
        $this->config = $config;

        parent::construct(
            $this->setUrl($this->config['url']),
            [$this->setAuth($this->config['key'])]
        );
    }

    public function setAuth($apiKey = null)
    {
        if (null === $apiKey) {
            $apiKey = config('multicoin.key');
        }

        $authentication       = new Bearer($apiKey);
        $authenticationPlugin = new AuthenticationPlugin($authentication);
        return $authenticationPlugin;
    }

    public function setUrl($url = null)
    {
        if (null === $url) {
            $this->url = config('multicoin.url');
            return $this;
        }

        return $url;

    }

    public function getcurrency()
    {
        $this->coin = $this->config['coin'];
        return $this;
    }

    public function address(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function txid(string $txid): self
    {
        $this->txid = $txid;
        return $this;
    }

}
