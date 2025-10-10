<?php

namespace Multicoin\Api\Tests;

use Multicoin\Api\Multicoin;
use PHPUnit\Framework\TestCase;

/**
 * Full API Test Coverage
 *
 * This test file demonstrates all available API endpoints
 * Uncomment the tests you want to run and provide valid test data
 */
class FullApiTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $config = [
            'api_token' => getenv('MULTICOIN_API_TOKEN') ?: 'your-api-token',
            'url' => getenv('MULTICOIN_API_URL') ?: 'https://api.example.com',
            'coin' => 'btc',
        ];

        $this->client = new Multicoin($config);
    }

    // ========================================
    // PUBLIC ENDPOINTS (No Auth Required)
    // ========================================

    /**
     * @test
     *
     * @group exchange-rates
     */
    public function test_get_exchange_rates()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getExchangeRates();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group exchange-rates
     */
    public function test_convert_currency()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->convertCurrency([
            'from' => 'USD',
            'to' => 'EUR',
            'amount' => 100,
        ]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group exchange-rates
     */
    public function test_get_exchange_rate_matrix()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getExchangeRateMatrix();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group exchange-rates
     */
    public function test_get_exchange_providers()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getExchangeProviders();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group exchange-rates
     */
    public function test_get_coin_rate()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getCoinRate();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_convert_crypto()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->convertCrypto([
            'from' => 'btc',
            'to' => 'eth',
            'amount' => 1,
        ]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_get_crypto_value()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getCryptoValue([
            'coin' => 'btc',
            'amount' => 1,
        ]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_batch_convert_crypto()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->batchConvertCrypto([
            'conversions' => [
                ['from' => 'btc', 'to' => 'eth', 'amount' => 1],
                ['from' => 'eth', 'to' => 'usdt', 'amount' => 10],
            ],
        ]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_get_conversion_fee()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getConversionFee();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_get_supported_cryptos()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getSupportedCryptos();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_convert_from_usd()
    {
        $this->markTestSkipped('Uncomment to run this test');

        // Test GET method
        $response = $this->client->convertFromUsd(['amount' => 100], 'GET');
        $this->assertNotEmpty($response);

        // Test POST method
        $response = $this->client->convertFromUsd(['amount' => 100], 'POST');
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_convert_to_atomic()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->convertToAtomic(['amount' => 1]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group crypto-convert
     */
    public function test_convert_to_base()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->convertToBase(['amount' => 100000000]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group websocket
     */
    public function test_block_notify()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->blockNotify([
            'hash' => '000000000019d6689c085ae165831e934ff763ae46a2a6c172b3f1b60a8ce26f',
            'height' => 0,
        ]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group websocket
     */
    public function test_transaction_notify()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->transactionNotify([
            'txid' => '4a5e1e4baab89f3a32518a88c31bc87f618f76673e2cc77ab2127b7afdeda33b',
        ]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group websocket
     */
    public function test_get_socketio_address_list()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getSocketioAddressList();
        $this->assertNotEmpty($response);
    }

    // ========================================
    // AUTHENTICATED ENDPOINTS
    // ========================================

    /**
     * @test
     *
     * @group user
     */
    public function test_user_info()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->info();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group user
     */
    public function test_core_balance()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->coreBalance();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group user
     */
    public function test_balance()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->balance();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group user
     */
    public function test_get_webhook_url()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->getWebhookUrl();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group invoice
     */
    public function test_create_invoice()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->createInvoice([
            'amount' => '0.001',
            'callback' => 'https://example.com/webhook',
        ]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group invoice
     */
    public function test_unpaid_invoice()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->unpaidInvoice();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group invoice
     */
    public function test_paid_invoice()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->paidInvoice();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_address_new()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->addressNew();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_address()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->address($address);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_address_balance()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->addressBalance($address);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_address_validate()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->addressValidate($address);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_address_txs()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->addressTxs($address, ['confirms' => 6]);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_address_utxo()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->addressUtxo($address);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_address_unconfirmed()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->addressUnconfirmed($address);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_transactions_from_db()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->transactionsFromDb($address);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group address
     */
    public function test_transactions_from_api()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $address = '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa';
        $response = $this->client->transactionsFromApi($address);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group transaction
     */
    public function test_transaction()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $txid = '4a5e1e4baab89f3a32518a88c31bc87f618f76673e2cc77ab2127b7afdeda33b';
        $response = $this->client->transaction($txid);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group transaction
     */
    public function test_transaction_validate()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $txid = '4a5e1e4baab89f3a32518a88c31bc87f618f76673e2cc77ab2127b7afdeda33b';
        $response = $this->client->transactionValidate($txid);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group transaction
     */
    public function test_transaction_confirmations()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $txid = '4a5e1e4baab89f3a32518a88c31bc87f618f76673e2cc77ab2127b7afdeda33b';
        $response = $this->client->transactionConfirmations($txid);
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group currency
     */
    public function test_active_currencys()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->activeCurrencys();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group currency
     */
    public function test_currency()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->currency();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group currency
     */
    public function test_fee()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->fee();
        $this->assertNotEmpty($response);
    }

    /**
     * @test
     *
     * @group withdrawal
     */
    public function test_withdraw()
    {
        $this->markTestSkipped('Uncomment to run this test');

        $response = $this->client->withdraw([
            'address' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa',
            'amount' => '0.001',
        ]);
        $this->assertNotEmpty($response);
    }
}
