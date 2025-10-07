<?php

// tests/Unit/MulticoinUnitTest.php

namespace Multicoin\Api\Tests\Unit;

use InvalidArgumentException;
use Multicoin\Api\Multicoin;
use PHPUnit\Framework\TestCase;

class MulticoinUnitTest extends TestCase
{
    public function test_setClient_requires_api_token()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('api_token');

        new Multicoin([
            'url' => 'https://api.example.com',
            'coin' => 'TBTC',
            // 'api_token' => missing
        ]);
    }

    public function test_setClient_requires_url()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('url');

        new Multicoin([
            'api_token' => 'token',
            'coin' => 'TBTC',
            // 'url' => missing
        ]);
    }

    public function test_buildUrl_uses_coin_prefix()
    {
        $api = new Multicoin([
            'api_token' => 'token',
            'url' => 'https://api.example.com',
            'coin' => 'TBTC',
        ]);

        $this->assertSame('/TBTC/addresses', $api->buildUrl('/addresses'));
        $this->assertSame('/TBTC/addresses', $api->buildUrl('addresses'));
    }

    public function test_buildQueryParam_merges_and_encodes()
    {
        $api = new Multicoin([
            'api_token' => 'token',
            'url' => 'https://api.example.com',
            'coin' => 'TBTC',
        ]);

        $query = $api->buildQueryParam(['a' => 1, 'b' => 2], ['b' => 3, 'c' => 'x y']);
        parse_str($query, $parsed);

        $this->assertSame(['a' => 1, 'b' => 3, 'c' => 'x y'], $parsed);
    }
}
