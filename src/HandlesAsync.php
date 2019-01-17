<?php

namespace Multicoin\Api;

use Exception;
use Psr\Http\Message\ResponseInterface;

trait HandlesAsync
{
    /**
     * Handles async request success.
     *
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  null|callable                       $callback
     * @return void
     */
    protected function onSuccess(ResponseInterface $response,  ? callable $callback = null) : void
    {
        if (!null === $callback) {
            $callback($response);
        }

    }

    /**
     * Handles async request failure.
     *
     * @param  \Exception    $exception
     * @param  null|callable $callback
     * @return void
     */
    protected function onError(Exception $exception,  ? callable $callback = null) : void
    {
        if (!null === $callback) {
            $callback($exception);
        }

    }

}
