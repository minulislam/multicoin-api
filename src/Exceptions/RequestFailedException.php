<?php

namespace Multicoin\Api\Exceptions;

use Exception;
use Throwable;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RequestFailedException extends Exception
{
    /**
     * @var ResponseInterface
     */
    protected $httpResponse;

    /**
     * @var RequestInterface
     */
    protected $httpRequest;

    /**
     * HttpRequestFailedException constructor.
     *
     * @param RequestInterface|ResponseInterface $requestOrResponse
     * @param int                                $code
     * @param null|Throwable                     $previous
     */
    public function __construct($requestOrResponse, int $code = 0, Throwable $previous = null)
    {
        if ($requestOrResponse instanceof ResponseInterface) {
            parent::__construct(
                'The HTTP request failed with the status code '.$requestOrResponse->getStatusCode(),
                $code,
                $previous
            );
            $this->httpResponse = $requestOrResponse;
        }

        if ($requestOrResponse instanceof RequestInterface) {
            $this->httpRequest = $requestOrResponse;
        }

        parent::__construct('The HTTP request failed unexpectedly.', $code, $previous);
    }

    /**
     * @return RequestInterface
     */
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * @return ResponseInterface
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

}
