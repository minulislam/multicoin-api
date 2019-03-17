<?php
namespace Multicoin\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Multicoin\Api\Exceptions\WebhookFailed;
use Symfony\Component\HttpFoundation\Response;
use Multicoin\Api\Http\Middlewares\VerifySignature;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifySignature::class);
    }

    public function __invoke(Request $request)
    {
        $eventPayload = json_decode($request->getContent(), true);

        if (!isset($eventPayload['type'])) {
            throw WebhookFailed::missingType($request);
        }
        logger('type', $eventPayload);
        $type = $eventPayload['type'];

        $ohDearWebhookCall = new WebhookCall($eventPayload);

        event("ohdear-webhooks::{$type}", $ohDearWebhookCall);

        $jobClass = $this->determineJobClass($type);

        if ('' === $jobClass) {
            return;
        }

        if (!class_exists($jobClass)) {
            throw WebhookFailed::jobClassDoesNotExist($jobClass, $ohDearWebhookCall);
        }

        dispatch(new $jobClass($ohDearWebhookCall));
    }

    public function index(Request $request)
    {
        if ($this->validateSignature($request)) {
            $events = $this->getJsonPayloadFromRequest($request);

            foreach ($events as $event) {
                $eventName = $event['event'] ?? 'undefined';

                if ('undefined' == $eventName && isset($event['type'])) {
                    $eventName = $event['type'];
                }

                $method = 'handle'.studly_case(str_replace('.', '_', $eventName));

                if (method_exists($this, $method)) {
                    $this->{$method}($event);
                }
            }

            return new Response;
        }

        return new Response('Unauthorized', 401);
    }

    /**
     * Generates a base64-encoded signature for webhook request.
     * @param string $webhook_key the webhook's authentication key
     * @param array  $request     the request's POST parameters
     */
    public function generateSignature($webhook_key, $request)
    {
        $timestamp = $request->header('timestamp');
        $token     = $request->header('token');

        return base64_encode(hash_hmac('sha256', $token.$timestamp, $webhook_key));
    }
    protected function determineJobClass(string $type): string
    {
        return config("multicoin.jobs.{$type}", '');
    }

    /**
     * Pull the Mandrill payload from the json.
     *
     * @param  $request
     * @return array
     */
    private function getJsonPayloadFromRequest($request)
    {
        $data = $request->json()->get('payload');

        return (array) json_decode($data, true);
    }

    /**
     * Validates the signature of a mandrill request if key is set.
     *
     * @param  Request $request
     * @param  string  $webhook_key
     * @return bool
     */
    private function validateSignature(Request $request)
    {
        $webhook_key = config('multicoin.webhook_token');

        if (!empty($webhook_key)) {
            $signature = $this->generateSignature($webhook_key, $request);

            return $request->header('X-Multicoin-Signature') === $signature;
        }

        return true;
    }
}
