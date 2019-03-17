<?php

namespace Multicoin\Api\Http\Middlewares;

use Closure;
use Multicoin\Api\Exceptions\WebhookFailed;

class VerifySignature
{
    public function handle($request, Closure $next)
    {
        $signature = $request->header('X-Multicoin-Signature');

        if (! $signature) {
            throw WebhookFailed::missingSignature();
        }

        if (! $this->isValid($signature, $request)) {
            throw WebhookFailed::invalidSignature($signature);
        }

        return $next($request);
    }

    protected function isValid(string $signature, $request): bool
    {
        $payload = $request->getContent();
        $secret = config('multicoin.webhook_token');
        if (empty($secret)) {
            throw WebhookFailed::signingSecretNotSet();
        }
        $timestamp = $request->header('timestamp');
        $token = $request->header('token');
        $computedSignature = hash_hmac('sha256', $token.$timestamp, $secret);
        // $computedSignature = hash_hmac('sha256', $payload, $secret);
        // return $signature===$computedSignature;

        return hash_equals($signature, $computedSignature);
    }
}
