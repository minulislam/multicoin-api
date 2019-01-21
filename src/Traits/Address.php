<?php

namespace Multicoin\Api\Traits;

trait Address
{
    public function addressNew()
    {
        $url = $this->buildUrlParam('/addr/new');

        $response = $this->doGet($url);

        return $response;
    }

    public function addressBalance($address)
    {
        $url      = $this->buildUrlParam('/addr/'.$address.'/balance');
        $response = $this->doGet($url);

        return $response;
    }

    public function address($address)
    {
        $url      = $this->buildUrlParam('/addr/'.$address);
        $response = $this->doGet($url);

        return $response;
    }

    public function addressTxs($address)
    {
        $url      = $this->buildUrlParam('/addr/'.$address.'/txs');
        $response = $this->doGet($url);

        return $response;
    }

    public function addressUtxo($address)
    {
        $url      = $this->buildUrlParam('/addr/'.$address.'/utxo');
        $response = $this->doGet($url);

        return $response;
    }

    public function addressValidate($address)
    {
        $url      = $this->buildUrlParam('/addr/'.$address.'/validate');
        $response = $this->doGet($url);

        return $response;
    }
}
