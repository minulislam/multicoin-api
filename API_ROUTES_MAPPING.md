# Multicoin API Routes Mapping

This document maps all Laravel API routes to their corresponding client methods in the multicoin-api package.

## Public Endpoints (No Authentication Required)

### Exchange Rate Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| GET | `/api/v1/exchange-rates` | `getExchangeRates()` | Get all exchange rates |
| GET | `/api/v1/exchange-rates/convert` | `convertCurrency($params)` | Convert between currencies |
| GET | `/api/v1/exchange-rates/matrix` | `getExchangeRateMatrix()` | Get exchange rate matrix |
| GET | `/api/v1/exchange-rates/providers` | `getExchangeProviders()` | Get exchange rate providers |
| GET | `/api/v1/{coin}/rate` | `getCoinRate()` | Get specific coin exchange rate |

### Crypto Convert Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| POST | `/api/v1/crypto-convert` | `convertCrypto($data)` | Convert cryptocurrency |
| POST | `/api/v1/crypto-convert/value` | `getCryptoValue($data)` | Get cryptocurrency value |
| POST | `/api/v1/crypto-convert/batch` | `batchConvertCrypto($data)` | Batch convert cryptocurrencies |
| GET | `/api/v1/crypto-convert/fee` | `getConversionFee()` | Get conversion fee |
| GET | `/api/v1/crypto-convert/supported` | `getSupportedCryptos()` | Get supported cryptocurrencies |
| GET/POST | `/api/v1/{coin}/convert-from-usd` | `convertFromUsd($data, $method)` | Convert from USD to cryptocurrency |
| GET | `/api/v1/{coin}/convert-to-atomic` | `convertToAtomic($params)` | Convert to atomic units |
| GET | `/api/v1/{coin}/convert-to-base` | `convertToBase($params)` | Convert to base units |

### WebSocket Callback Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| POST | `/api/v1/{coin}/socketio/block` | `blockNotify($data)` | Notify block event via WebSocket |
| POST | `/api/v1/{coin}/socketio/tx` | `transactionNotify($data)` | Notify transaction event via WebSocket |
| GET | `/api/v1/{coin}/socketio/addresslist` | `getSocketioAddressList()` | Get address list for WebSocket monitoring |

## Authenticated Endpoints (Requires API Token)

### User Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| GET | `/api/v1/user` | `info()` | Get current user information |
| GET | `/api/v1/user/core-balance` | `coreBalance()` | Get user's core balance |
| GET | `/api/v1/user/{coin}/balance` | `balance()` | Get user's balance for specific coin |
| GET | `/api/v1/user/webhook` | `getWebhookUrl($params)` | Get webhook URL (UPDATE permission required) |

### Invoice Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| GET | `/api/v1/{coin}/receive` | `createInvoice($params)` | Generate payment address (CREATE permission required) |
| GET | `/api/v1/{coin}/unpaid-invoices` | `unpaidInvoice()` | Get unpaid invoices |
| GET | `/api/v1/{coin}/paid-invoices` | `paidInvoice()` | Get paid invoices |

### Address Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| GET | `/api/v1/{coin}/addr/new` | `addressNew()` | Create new address (CREATE permission required) |
| GET | `/api/v1/{coin}/addr/{address}` | `address($address)` | Get address information |
| GET | `/api/v1/{coin}/addr/{address}/balance` | `addressBalance($address)` | Get address balance |
| GET | `/api/v1/{coin}/addr/{address}/validate` | `addressValidate($address)` | Validate address |
| GET | `/api/v1/{coin}/addr/{address}/txs` | `addressTxs($address, $params)` | Get address transactions |
| GET | `/api/v1/{coin}/addr/{address}/utxo` | `addressUtxo($address)` | Get address UTXOs |
| GET | `/api/v1/{coin}/addr/{address}/unconfirmed` | `addressUnconfirmed($address)` | Get unconfirmed transactions |
| GET | `/api/v1/{coin}/addr/{address}/txfromdb` | `transactionsFromDb($address)` | Get transactions from database |
| GET | `/api/v1/{coin}/addr/{address}/txfromapi` | `transactionsFromApi($address)` | Get transactions from API |

### Transaction Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| GET | `/api/v1/{coin}/tx/{txid}` | `transaction($txid)` | Get transaction details |
| GET | `/api/v1/{coin}/tx/{txid}/validate` | `transactionValidate($txid)` | Validate transaction |
| GET | `/api/v1/{coin}/tx/{txid}/confirmations` | `transactionConfirmations($txid)` | Get transaction confirmations |

### Currency Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| GET | `/api/v1/currency` | `activeCurrencys()` | Get list of active currencies |
| GET | `/api/v1/{coin}/index` | `currency()` | Get currency information |
| GET | `/api/v1/{coin}/fee` | `fee()` | Get currency fee |

### Withdrawal Endpoints

| HTTP Method | API Route | Client Method | Description |
|-------------|-----------|---------------|-------------|
| GET | `/api/v1/{coin}/withdraw` | `withdraw($params)` | Create withdrawal request (CREATE permission required) |

## Usage Examples

### Initialize the client
```php
use Multicoin\Api\Multicoin;

$config = [
    'api_token' => 'your-api-token',
    'url' => 'https://your-api-url.com',
    'coin' => 'btc'
];

$client = new Multicoin($config);
```

### Public endpoints (no auth required)
```php
// Get exchange rates
$rates = $client->getExchangeRates();

// Convert cryptocurrency
$result = $client->convertCrypto([
    'from' => 'btc',
    'to' => 'eth',
    'amount' => 1
]);

// Get coin rate
$rate = $client->getCoinRate();
```

### Authenticated endpoints
```php
// Get user info
$user = $client->info();

// Get user balance
$balance = $client->balance();

// Create new address
$address = $client->addressNew();

// Get address transactions
$txs = $client->addressTxs('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', [
    'confirms' => 6
]);

// Create invoice
$invoice = $client->createInvoice([
    'amount' => '0.001',
    'callback' => 'https://your-site.com/webhook'
]);

// Create withdrawal
$withdrawal = $client->withdraw([
    'address' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa',
    'amount' => '0.001'
]);
```

## Permission Levels

The authenticated routes require different permission levels:

- **authorize.resource:create** - Required for creating resources (addresses, withdrawals)
- **authorize.resource:update** - Required for updating resources (webhooks)
- **authorize.resource:view** - Required for viewing resources (own data)

## Rate Limiting

Public endpoints have rate limiting applied:
- Exchange rate endpoints: 60 requests per minute
- Crypto convert endpoints: 60 requests per minute
- Coin-specific conversion endpoints: 60 requests per minute