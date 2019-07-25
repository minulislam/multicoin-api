<?php

namespace Multicoin\Api\Traits;

trait User
{
    public function balance()
    {
        $url = '/user/'.$this->coin.'/balance';
        $response = $this->client->doGet($url);

        return $response;
    }

    public function coreBalance()
    {
        $url = '/user/core-balance';
        $response = $this->client->doGet($url);

        return $response;
    }

    public function info()
    {
        $url = '/user';
        $response = $this->client->doGet($url);

        return $response;
    }

    public function setWebhookUrl($url)
    {
        $url = '/user/webhook';
        $response = $this->client->doPost($url, ['url'=>$url]);

        return $response;
    }
}
