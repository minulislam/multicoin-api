<?php

namespace Multicoin\Api\Traits;

trait Currency
{
    public function activeCurrencys()
    {
        $url = '/currency';
        $response = $this->client->doGet($url);

        return $response;
    }

    public function currency()
    {
        $url = $this->buildUrl('/index');
        $response = $this->client->doGet($url);

        return $response;
    }

    // binance
    // bitcoinaverage
    // Bitstamp
    // Bittrex
    // CoinMarketCap
    // Poloniex
    public function currencyQuote($provider = null, $coin = null)
    {
        $client = new \Tokenly\CryptoQuoteClient\Client();
        $quote = $client->getQuote($provider ?? 'bitcoinAverage', 'USD', $coin ?? $this->coin);

        return collect($quote);
    }
}
