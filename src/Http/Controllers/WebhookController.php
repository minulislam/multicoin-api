<?php

namespace Multicoin\Api\Http\Controllers;

use Illuminate\Http\Request;
use Multicoin\Api\WebhookCall;
use Illuminate\Routing\Controller;
use Multicoin\Api\Exceptions\WebhookFailed;
use Multicoin\Api\Http\Middlewares\VerifySignature;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifySignature::class);
    }

    public function __invoke(Request $request)
    {
        $eventPayload = $this->getJsonPayloadFromRequest($request);

        // $eventPayload = json_decode($request->getContent(), true);
        if (! isset($eventPayload['type'])) {
            logger('eventPayload Type doesnt exist',$eventPayload );
            throw WebhookFailed::missingType($request);
        }

        $type = $eventPayload['type'];

        $WebhookCall = new WebhookCall($eventPayload);

        event("multicoin-webhooks::{$type}", $WebhookCall);

        $jobClass = $this->determineJobClass($type);

        if ('' === $jobClass) {
            return;
        }

        if (! class_exists($jobClass)) {
            throw WebhookFailed::jobClassDoesNotExist($jobClass, $WebhookCall);
        }

        dispatch(new $jobClass($WebhookCall));
    }

    public function generateSignature($webhook_key, $request)
    {
        $timestamp = $request->header('timestamp');
        $token = $request->header('token');

        return base64_encode(hash_hmac('sha256', $token.$timestamp, $webhook_key));
    }

    protected function determineJobClass(string $type)
    {
        return config("multicoin.jobs.{$type}", '');
    }

    private function getJsonPayloadFromRequest($request)
    {
        return (array) json_decode($request->getContent(), true);
    }
}
