<?php

namespace Multicoin\Api;

class WebhookCall
{
    public $payload = [];

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function type(): string
    {
        return $this->payload['type'];
    }

    public function transaction(): array
    {
        return $this->payload['transaction'];
    }

    public function currency(): string
    {
        return $this->payload['currency'];
    }

    public function coin(): string
    {
        return $this->payload['coin'];
    }

    public function amount()
    {
        return $this->payload['value'];
    }

    public function btc()
    {
        return $this->payload['value'] / 100000000;
    }

    public function address(): string
    {
        return $this->payload['address_to'];
    }

    public function from(): string
    {
        return $this->payload['address_from'];
    }

    public function txid(): string
    {
        return $this->payload['txid'];
    }

    public function confirmations(): string
    {
        return $this->payload['confirmations'];
    }
}
