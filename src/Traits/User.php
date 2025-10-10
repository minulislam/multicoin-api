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

    public function getWebhookUrl(array $params = [])
    {
        $url = '/user/webhook';
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        $response = $this->client->doGet($url);

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
