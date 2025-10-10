<?php

namespace Multicoin\Api\Traits;

trait ExchangeRate
{
    /**
     * Get all exchange rates
     * GET /api/v1/exchange-rates
     */
    public function getExchangeRates()
    {
        $url = '/exchange-rates';
        $response = $this->client->doGet($url);

        return $response;
    }

    /**
     * Convert between currencies
     * GET /api/v1/exchange-rates/convert
     */
    public function convertCurrency(array $params = [])
    {
        $url = '/exchange-rates/convert';
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        $response = $this->client->doGet($url);

        return $response;
    }

    /**
     * Get exchange rate matrix
     * GET /api/v1/exchange-rates/matrix
     */
    public function getExchangeRateMatrix()
    {
        $url = '/exchange-rates/matrix';
        $response = $this->client->doGet($url);

        return $response;
    }

    /**
     * Get exchange rate providers
     * GET /api/v1/exchange-rates/providers
     */
    public function getExchangeProviders()
    {
        $url = '/exchange-rates/providers';
        $response = $this->client->doGet($url);

        return $response;
    }

    /**
     * Get specific coin exchange rate
     * GET /api/v1/{coin}/rate
     */
    public function getCoinRate()
    {
        $url = $this->buildUrl('/rate');
        $response = $this->client->doGet($url);

        return $response;
    }
}