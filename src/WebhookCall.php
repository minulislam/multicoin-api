<?php

namespace Multicoin\Api;

class WebhookCall
{
    public $payload = [];

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function address(): string
    {
        return $this->payload['address_to'];
    }

    public function amount()
    {
        return $this->payload['value'];
    }

    public function amountCrypto()
    {
        // Use conversion info if available for accurate conversion
        if (isset($this->payload['conversion_info']['base_unit_value'])) {
            return $this->payload['conversion_info']['base_unit_value'];
        }

        // Fallback to hardcoded division (legacy support)
        return $this->payload['value'] / 100000000;
    }

    public function coin(): string
    {
        return $this->payload['coin'] ?? $this->payload['currency'];
    }

    public function conversionInfo(): ?array
    {
        return $this->payload['conversion_info'] ?? null;
    }

    public function baseUnitValue(): ?string
    {
        return $this->payload['conversion_info']['base_unit_value'] ?? null;
    }

    public function atomicUnitValue(): ?string
    {
        return $this->payload['conversion_info']['atomic_unit_value'] ?? null;
    }

    public function atomicUnitName(): ?string
    {
        return $this->payload['conversion_info']['atomic_unit_name'] ?? null;
    }

    public function decimals(): ?int
    {
        return $this->payload['conversion_info']['decimals'] ?? null;
    }

    public function detectedAs(): ?string
    {
        return $this->payload['conversion_info']['detected_as'] ?? null;
    }

    public function confirmations(): string
    {
        return $this->payload['confirmations'];
    }

    public function currency(): string
    {
        return $this->payload['currency'];
    }

    public function name(): string
    {
        return $this->payload['coin_name'];
    }

    public function from(): string
    {
        return $this->payload['address_from'];
    }

    public function transaction(): array
    {
        return $this->payload['transaction'];
    }

    public function txid(): string
    {
        return $this->payload['txid'];
    }

    public function type(): string
    {
        return $this->payload['type'];
    }
}
