<?php

namespace Multicoin\Api\Http\Middlewares;

use Closure;
use OhDear\LaravelWebhooks\Exceptions\WebhookFailed;

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
        $computedSignature = $this->generateSignature($secret, $request);
        // $computedSignature = hash_hmac('sha256', $payload, $secret);
        return $signature === $computedSignature;

        return hash_equals($signature, $computedSignature);
    }

    protected function generateSignature($secret, $request)
    {
        $timestamp = $request->header('timestamp');
        $token = $request->header('token');

        return base64_encode(hash_hmac('sha256', $token.$timestamp, $secret));
    }
}
