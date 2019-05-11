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
        if (! isset($eventPayload['type'])) {
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

    protected function determineJobClass(string $type)
    {
        return config("multicoin.jobs.{$type}", '');
    }

    private function getJsonPayloadFromRequest($request)
    {
        return (array) json_decode($request->getContent(), true);
    }
}
