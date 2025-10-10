<?php

namespace Multicoin\Api\Traits;

trait CryptoConvert
{
    /**
     * Convert cryptocurrency
     * POST /api/v1/crypto-convert.
     */
    public function convertCrypto(array $data)
    {
        $url = '/crypto-convert';
        $response = $this->client->doPost($url, $data);

        return $response;
    }

    /**
     * Get cryptocurrency value
     * POST /api/v1/crypto-convert/value.
     */
    public function getCryptoValue(array $data)
    {
        $url = '/crypto-convert/value';
        $response = $this->client->doPost($url, $data);

        return $response;
    }

    /**
     * Batch convert cryptocurrencies
     * POST /api/v1/crypto-convert/batch.
     */
    public function batchConvertCrypto(array $data)
    {
        $url = '/crypto-convert/batch';
        $response = $this->client->doPost($url, $data);

        return $response;
    }

    /**
     * Get conversion fee
     * GET /api/v1/crypto-convert/fee.
     */
    public function getConversionFee()
    {
        $url = '/crypto-convert/fee';
        $response = $this->client->doGet($url);

        return $response;
    }

    /**
     * Get supported cryptocurrencies
     * GET /api/v1/crypto-convert/supported.
     */
    public function getSupportedCryptos()
    {
        $url = '/crypto-convert/supported';
        $response = $this->client->doGet($url);

        return $response;
    }

    /**
     * Convert from USD to cryptocurrency
     * GET|POST /api/v1/{coin}/convert-from-usd.
     */
    public function convertFromUsd(array $data = [], $method = 'GET')
    {
        $url = $this->buildUrl('/convert-from-usd');

        if (strtoupper($method) === 'POST') {
            $response = $this->client->doPost($url, $data);
        } else {
            if (! empty($data)) {
                $url .= '?'.http_build_query($data);
            }
            $response = $this->client->doGet($url);
        }

        return $response;
    }

    /**
     * Convert to atomic units
     * GET /api/v1/{coin}/convert-to-atomic.
     */
    public function convertToAtomic(array $params = [])
    {
        $url = $this->buildUrl('/convert-to-atomic');
        if (! empty($params)) {
            $url .= '?'.http_build_query($params);
        }
        $response = $this->client->doGet($url);

        return $response;
    }

    /**
     * Convert to base units
     * GET /api/v1/{coin}/convert-to-base.
     */
    public function convertToBase(array $params = [])
    {
        $url = $this->buildUrl('/convert-to-base');
        if (! empty($params)) {
            $url .= '?'.http_build_query($params);
        }
        $response = $this->client->doGet($url);

        return $response;
    }
}
