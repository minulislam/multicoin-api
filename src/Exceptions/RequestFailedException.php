<?php

namespace Multicoin\Api\Exceptions;

use Http\Client\Exception\HttpException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Exception thrown when an HTTP request fails and we want to expose the direct response body.
 */
class RequestFailedException extends HttpException
{
    /**
     * Create a new RequestFailedException.
     */
    public function __construct(RequestInterface $request, ResponseInterface $response, ?Throwable $previous = null)
    {
        $bodyString = '';
        try {
            $bodyString = (string) $response->getBody();
        } catch (\Throwable $e) {
            $bodyString = '';
        }

        // Limit body preview to avoid huge messages
        $preview = trim(mb_substr($bodyString, 0, 2000));
        if ($preview === '' && $bodyString !== '') {
            // Fallback if mbstring not available
            $preview = trim(substr($bodyString, 0, 2000));
        }

        $message = sprintf(
            'HTTP %d %s for %s %s. Response body: %s',
            $response->getStatusCode(),
            $response->getReasonPhrase(),
            $request->getMethod(),
            (string) $request->getUri(),
            $preview
        );

        parent::__construct($message, $request, $response, $previous);
    }

    /**
     * Get the full raw response body as a string.
     */
    public function getResponseBody(): string
    {
        try {
            return (string) $this->getResponse()->getBody();
        } catch (\Throwable $e) {
            return '';
        }
    }
}
