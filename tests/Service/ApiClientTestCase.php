<?php

// tests/Service/ApiClientTest.php

namespace Multicoin\Api\Tests\Service;

use Http\Mock\Client as MockClient;
use Multicoin\Api\Service\ApiClient;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiClientTestCase extends TestCase
{
    private function makeClientWithMock(MockClient $mock, string $baseUrl = 'https://api.example.com'): ApiClient
    {
        // Pass the mock HTTP client directly into ApiClient
        return new ApiClient($baseUrl, [], true, $mock);
    }

    public function test_do_get_parses_json_and_returns_collection()
    {
        $mock = new MockClient;
        $mock->setDefaultResponse(new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'ok' => true,
            'data' => ['a' => 1],
        ])));

        $client = $this->makeClientWithMock($mock);

        $result = $client->doGet('/status');

        $this->assertTrue($result->get('ok'));
        $this->assertSame(1, $result->get('data')['a']);
    }

    public function test_do_post_sends_headers_and_parses_response()
    {
        $mock = new MockClient;
        $mock->setDefaultResponse(new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'saved' => true,
        ])));

        $client = $this->makeClientWithMock($mock);

        $headers = ['X-Trace-Id' => 'abc-123'];
        $result = $client->doPost('/resources', $headers);

        $this->assertTrue($result->get('saved'));

        $request = $mock->getLastRequest();
        $this->assertNotNull($request, 'Expected a request to have been sent');
        $this->assertTrue($request->hasHeader('X-Trace-Id'));
        $this->assertSame(['abc-123'], $request->getHeader('X-Trace-Id'));
    }

    public function test_execute_request_throws_on_invalid_json()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Invalid JSON response');

        $mock = new MockClient;
        $mock->setDefaultResponse(new Response(200, ['Content-Type' => 'application/json'], 'not-json'));

        $client = $this->makeClientWithMock($mock);

        $client->doGet('/anything');
    }
}
