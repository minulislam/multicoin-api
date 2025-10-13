<?php

declare(strict_types=1);

namespace Multicoin\Api\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Multicoin\Api\WebhookCall;

class WebhookFailed extends Exception
{
    private const SIGNATURE_HEADER = 'X-Multicoin-Signature';

    private const API_KEY_CONFIG = 'multicoin.api_key';

    public static function jobClassDoesNotExist(string $jobClass, WebhookCall $webhookCall): self
    {
        return new static(
            "Configured job class '{$jobClass}' for webhook type `{$webhookCall->type()}` was not found."
        );
    }

    public static function invalidSignature(string $signature): self
    {
        return new static("The signature `{$signature}` found in the header named `".self::SIGNATURE_HEADER.'` is invalid. '.
            'Make sure that the `'.self::API_KEY_CONFIG.'` config key is set to the value you found on the multicoin account.');
    }

    public static function missingSignature(): self
    {
        return new static('The request did not contain a header named `'.self::SIGNATURE_HEADER.'`.');
    }

    public static function missingType(Request $request): self
    {
        return new static('The webhook call did not contain a type. Valid calls should always contain a type.');
    }

    public static function invalidPayload(Request $request): self
    {
        return new static('The webhook call did not contain any valid payload.');
    }

    public static function invalidJson(Request $request, string $error): self
    {
        return new static("The webhook call contained invalid JSON: {$error}");
    }

    public static function signingSecretNotSet(): self
    {
        return new static('The webhook signing secret is not set. '.
            'Make sure that the `'.self::API_KEY_CONFIG.'` config key is set.');
    }

    public function render($request)
    {
        return response()->json(['error' => $this->getMessage()], 400);
    }
}
