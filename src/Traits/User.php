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

    public function setWebhookUrl($endPoint)
    {
        $url = '/user/webhook';
        $response = $this->client->doPost($url, ['url' => $endPoint]);

        return $response;
    }

    public function withdraw(array $param = [])
    {
        $url = $this->buildUrl('/withdraw');
        $url .= '?'.http_build_query($param);
        $response = $this->client->doGet($url);

        return $response;
    }
}
