<?php

namespace Multicoin\Api\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class WebhookController extends Controller
{
    public function handleWebHook(Request $request)
    {
        if ($this->validateSignature($request)) {
            $events = $this->getJsonPayloadFromRequest($request);

            foreach ($events as $event) {
                $eventName = isset($event['event']) ? $event['event'] : 'undefined';

                if ('undefined' == $eventName && isset($event['type'])) {
                    $eventName = $event['type'];
                }

                $method = 'handle'.studly_case(str_replace('.', '_', $eventName));

                if (method_exists($this, $method)) {
                    $this->{$method}
                    ($event);
                }

            }

            return new Response;
        }

        return new Response('Unauthorized', 401);
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

}
