<?php

namespace Multicoin\Api\Traits;

trait Address
{
    public function __construct()
    {
        parent::construct();
    }

    public function addressNew()
    {
        /**
         * [GET api/v1/{coin}/addr/new]
         */
        $url      = $this->coin.'/addr/new';
        $response = $this->doGet($url);
        return $response;
    }

    public function addressBalance()
    {
        /**
         * GET api/v1/{coin}/addr/{address}/balance
         */
        $url      = $this->coin.'/addr/'.$this->address.'/balance';
        $response = $this->doGet($url);
        return $response;

    }

    public function addressDetails()
    {
        /**
         * GET api/v1/{coin}/addr/{address}
         */
        $url      = $this->coin.'/addr/'.$this->address;
        $response = $this->doGet($url);
        return $response;

    }

    public function addressTxs()
    {
        /**
         * GET api/v1/{coin}/addr/{address}/txs
         */
        $url      = $this->coin.'/addr/'.$this->address.'/txs';
        $response = $this->doGet($url);
        return $response;
    }

    public function addressUtxs()
    {
        /**
         * GET api/v1/{coin}/addr/{address}/utxo
         */
        $url      = $this->coin.'/addr/'.$this->address.'/utxo';
        $response = $this->doGet($url);
        return $response;
    }

    public function addressValidate()
    {
        /**
         * GET api/v1/{coin}/addr/{address}/validate
         */
        $url      = $this->coin.'/addr/'.$this->address.'/validate';
        $response = $this->doGet($url);
        return $response;
    }

}
