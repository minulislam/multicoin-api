<?php

namespace Multicoin\Api\Traits;

trait Address
{
    public function address($address)
    {
        $url = $this->buildUrl('/addr/'.$address);
        $response = $this->client->doGet($url);

        return $response;
    }

    public function addressBalance($address)
    {
        $url = $this->buildUrl('/addr/'.$address.'/balance');
        $response = $this->client->doGet($url);

        return $response;
    }
    public function addressNew()
    {
        $url = $this->buildUrl('/addr/new');

        $response = $this->client->doGet($url);

        return $response;
    }

    public function addressTxs($address, array $param = [])
    {
        $default = ['confirms' => 0];
        $url = $this->buildUrl('/addr/'.$address.'/txs');
        $url .= '?'.$this->buildQueryParam($default, $param);
        $response = $this->client->doGet($url);

        return $response;
    }

    public function addressUtxo($address)
    {
        $url = $this->buildUrl('/addr/'.$address.'/utxo');
        $response = $this->client->doGet($url);

        return $response;
    }

    public function addressValidate($address)
    {
        $url = $this->buildUrl('/addr/'.$address.'/validate');
        $response = $this->client->doGet($url);

        return $response;
    }

    public function transactionsFromApi($address)
    {
        $url = $this->buildUrl('/'.$address.'/txfromapi');
        $response = $this->client->doGet($url);

        return $response;
    }

    public function transactionsFromDb($address)
    {
        $url = $this->buildUrl('/'.$address.'/txfromdb');
        $response = $this->client->doGet($url);

        return $response;
    }
}
