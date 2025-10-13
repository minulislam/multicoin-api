<?php

namespace Multicoin\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Multicoin\Api\Exceptions\WebhookFailed;
use Multicoin\Api\Http\Middlewares\VerifySignature;
use Multicoin\Api\WebhookCall;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifySignature::class);
    }

    public function __invoke(Request $request): JsonResponse
    {
        $eventPayload = $this->getJsonPayloadFromRequest($request);

        if (! isset($eventPayload['type'])) {
            throw WebhookFailed::missingType($request);
        }

        $type = $eventPayload['type'];
        $webhookCall = new WebhookCall($eventPayload);

        // Log before processing
        Log::info('Webhook received', [
            'type' => $type,
            'payload' => $eventPayload,
        ]);

        // Fire event
        event("multicoin-webhooks::{$type}", $webhookCall);

        $jobClass = $this->determineJobClass($type);

        if ($jobClass === '') {
            Log::warning('No job configured for webhook type', ['type' => $type]);

            return response()->json([
                'status' => true,
                'message' => 'Webhook received but no handler configured',
            ]);
        }

        if (! class_exists($jobClass)) {
            throw WebhookFailed::jobClassDoesNotExist($jobClass, $webhookCall);
        }

        Bus::dispatch(new $jobClass($webhookCall));

        return response()->json([
            'status' => true,
            'message' => 'Webhook processing initiated',
        ]);
    }

    protected function determineJobClass(string $type): string
    {
        return config("multicoin.jobs.{$type}", '');
    }

    private function getJsonPayloadFromRequest(Request $request): array
    {
        $content = $request->getContent();

        if (empty($content)) {
            throw WebhookFailed::invalidPayload($request);
        }

        $payload = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw WebhookFailed::invalidJson($request, json_last_error_msg());
        }

        return $payload ?? [];
    }
}
