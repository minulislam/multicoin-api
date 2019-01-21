<?php

namespace Multicoin\Api\Exceptions;

use Throwable;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Http\Client\Common\Exception\ClientErrorException;

class RequestFailedException extends ClientErrorException
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
                'The HTTP request Response failed with the status code '.$requestOrResponse->getStatusCode(),
                $requestOrResponse->getRequest(),
                $requestOrResponse->getReasponse(),
                $previous
            );
            $this->httpResponse = $requestOrResponse;
        }

        if ($requestOrResponse instanceof RequestInterface) {
            $this->httpRequest = $requestOrResponse;
        }

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
