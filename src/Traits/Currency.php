<?php

namespace Multicoin\Api\Traits;

trait Currency
{
    public function activeCurrencys()
    {
        $url      = '/currency';
        $response = $this->doGet($url);
        return $response;
    }public function currency()
    {
        $url      = $this->buildUrl('/index');
        $response = $this->doGet($url);
        return $response;
    }
}
