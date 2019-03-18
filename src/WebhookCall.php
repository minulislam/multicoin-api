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

    public function coin(): array
    {
        return $this->payload['coin'];
    }
}
