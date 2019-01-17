<?php

namespace Multicoin\Api;

use Multicoin\Api\Service\HttpService;
use Http\Message\Authentication\Bearer;

class Multicoin extends HttpService
{
    public function __construct($url = '', $apiKey = '')
    {
        $this->setBaseUrl($url);
        $this->setApiKey($apiKey);
        $authentication = new Bearer('token');
    }

    public function activeCoin()
    {
        return $phrase;
    }
}
