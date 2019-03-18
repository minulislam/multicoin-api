<?php

namespace Multicoin\Api\Traits;

trait Transaction
{
    public function transaction($txid)
    {
        $url = $this->buildUrl('/tx/'.$txid);
        $response = $this->client->doGet($url);

        return $response;
    }

    public function transactionValidate($txid)
    {
        $url = $this->buildUrl('/tx/'.$txid.'/validate');
        $response = $this->client->doGet($url);

        return $response;
    }

    public function transactionConfirmations($txid)
    {
        $url = $this->buildUrl('/tx/'.$txid.'/confirmations');
        $response = $this->client->doGet($url);

        return $response;
    }
}
