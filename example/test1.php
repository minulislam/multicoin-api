<?php

require '../vendor/autoload.php';
use Multicoin\Api\ApiClient;
$api = new ApiClient();
dd($api->doStuff());
