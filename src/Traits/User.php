<?php

namespace Multicoin\Api\Traits;

trait User
{
    public function coreBalance()
    {
        $url      = '/user/core-balance';
        $response = $this->doGet($url);

        return $response;
    }

    public function balance()
    {
        $url      = '/user/'.$this->coin.'/balance';
        $response = $this->doGet($url);

        return $response;
    }

    public function info()
    {
        $url      = '/user';
        $response = $this->doGet($url);

        return $response;
    }
}
