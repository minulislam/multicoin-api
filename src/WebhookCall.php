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

    public function transaction(): string
    {
        return $this->payload['transaction'];
    }

    public function currency(): array
    {
        return $this->payload['currency'];
    }

    public function run(): array
    {
        return $this->payload['run'];
    }
}
