<?php

namespace Multicoin\Api\Traits;

trait Currency
{
    public function activeCurrencys()
    {
        $url = '/currency';
        $response = $this->client->doGet($url);

        return $response;
    }

    public function currency()
    {
        $url = $this->buildUrl('/index');
        $response = $this->client->doGet($url);

        return $response;
    }

    public function fee()
    {
        $url = $this->buildUrl('/fee');
        $response = $this->client->doGet($url);

        return $response;
    }


}
