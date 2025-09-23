<?php

// tests/Http/WebhookControllerTest.php

namespace Multicoin\Api\Tests\Http;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Multicoin\Api\Exceptions\WebhookFailed;
use Multicoin\Api\Http\Controllers\WebhookController;
use Multicoin\Api\Http\Middlewares\VerifySignature;
use Multicoin\Api\Tests\TestbenchTestCase;
use Multicoin\Api\WebhookCall;

class WebhookControllerTest extends TestbenchTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Define a route pointing to the controller
        Route::post('/webhook/multicoin', WebhookController::class);
    }

    public function test_missing_type_throws_exception()
    {
        $this->withoutMiddleware([VerifySignature::class]);

        $this->expectException(WebhookFailed::class);

        $this->postJson('/webhook/multicoin', []);
    }

    public function test_no_configured_job_returns_no_content_and_fires_event()
    {
        $this->withoutMiddleware([VerifySignature::class]);

        Event::fake();

        // No job configured for this event type
        config()->set('multicoin.jobs.invoice.paid', '');

        $response = $this->postJson('/webhook/multicoin', [
            'type' => 'invoice.paid',
            'payload' => ['id' => 123],
        ]);

        $response->assertNoContent();

        Event::assertDispatched(function ($name, $payload) {
            return $name === 'multicoin-webhooks::invoice.paid'
                && isset($payload[0])
                && $payload[0] instanceof WebhookCall;
        });
    }

    public function test_configured_job_is_dispatched()
    {
        $this->withoutMiddleware([VerifySignature::class]);

        Bus::fake();
        Event::fake();

        config()->set('multicoin.jobs.invoice.paid', DummyInvoicePaidJob::class);

        $response = $this->postJson('/webhook/multicoin', [
            'type' => 'invoice.paid',
            'payload' => ['id' => 456],
        ]);

        $response->assertSuccessful(); // dispatch() returns a response-like value in tests; successful indicates 200

        Bus::assertDispatched(DummyInvoicePaidJob::class, function ($job) {
            return property_exists($job, 'webhookCall')
                && $job->webhookCall instanceof WebhookCall;
        });

        Event::assertDispatched('multicoin-webhooks::invoice.paid');
    }
}

/**
 * Dummy job used for dispatch assertion.
 */
class DummyInvoicePaidJob
{
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle(): void
    {
        // no-op
    }
}
