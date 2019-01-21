<?php

namespace Multicoin\Api\Traits;

trait Transaction
{
    public function transactionsFromDb($address)
    {
        $url = $this->buildUrl('/'.$address.'/txfromdb');
        $response = $this->doGet($url);

        return $response;
    }

    public function transactionsFromApi($address)
    {
        $url = $this->buildUrl('/'.$address.'/txfromapi');
        $response = $this->doGet($url);

        return $response;
    }

    public function transaction($txid)
    {
        $url = $this->buildUrl('/tx/'.$txid);
        $response = $this->doGet($url);

        return $response;
    }

    public function transactionValidate($txid)
    {
        $url = $this->buildUrl('/tx/'.$txid.'/validate');
        $response = $this->doGet($url);

        return $response;
    }

    public function transactionConfirmations($txid)
    {
        $url = $this->buildUrl('/tx/'.$txid.'/confirmations');
        $response = $this->doGet($url);

        return $response;
    }
}
