<?php

namespace Multicoin\Api\Exceptions;

use Exception;
use Illuminate\Http\Request;

class WebhookFailed extends Exception
{
    public static function invalidSignature($signature)
    {
        return new static("The signature `{$signature}` found in the header named `X-Multicoin-Signature` is invalid.
            Make sure that the `multicoin.api_key` config key is set to the value you found on the multicoin account.");
    }

    public static function missingSignature()
    {
        return new static('The request did not contain a header named `X-Multicoin-Signature`.');
    }

    public static function missingType(Request $request)
    {
        return new static('The webhook call did not contain a type. Valid calls should always contain a type.');
    }

    public function render($request)
    {
        return response(['error' => $this->getMessage()], 400);
    }

    public static function signingSecretNotSet()
    {
        return new static('The webhook signing secret is not set.
            Make sure that the `multicoin.api_key` config key is set.');
    }
}
