# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Multicoin API Client is a PHP library for interacting with multicoin cryptocurrency APIs. It provides a clean interface for cryptocurrency operations including address management, transactions, invoices, and user operations across multiple cryptocurrencies (BTC, TBTC, LTC).

## Development Commands

### Testing
```bash
# Run all tests
composer test

# Run specific test file
vendor/bin/phpunit tests/ExampleTest.php

# Run with coverage (if xdebug installed)
vendor/bin/phpunit --coverage-html coverage
```

### Code Quality
```bash
# Fix code style issues
composer fixer

# Run StyleCI locally (if php-cs-fixer is installed)
php-cs-fixer fix
```

### Installation & Setup
```bash
# Install dependencies
composer install

# Update dependencies
composer update

# Optimize autoloader for production
composer dump-autoload -o
```

## Architecture Overview

### Core Structure
The library follows a trait-based architecture pattern where functionality is organized into logical groups:

- **Main Entry Point**: `src/Multicoin.php` - Central class that composes traits and manages API client configuration
- **Traits**: Located in `src/Traits/` - Modular functionality grouped by domain:
  - `Address.php` - Address validation, balance checks, transaction history
  - `Invoice.php` - Invoice creation and status management
  - `Transaction.php` - Transaction validation and confirmations
  - `User.php` - User-related operations
  - `Currency.php` - Currency management and queries

### HTTP Client Architecture
The library uses PSR-18 HTTP client abstraction with plugin-based middleware:

- **ApiClient**: `src/Service/ApiClient.php` - Manages HTTP client with configurable plugins
- **Plugins**: Authentication (Bearer token), JSON decoding, error handling, retry logic
- **HTTP Discovery**: Auto-discovers compatible HTTP clients (Guzzle7, Symfony HTTP Client)

### Laravel Integration
When used in Laravel applications:

- **Service Provider**: `src/MulticoinServiceProvider.php` - Registers bindings and publishes config
- **Facade**: `src/Facade/Multicoin.php` - Provides static interface
- **Factory**: `src/MulticoinFactory.php` - Creates configured instances
- **Config**: Published to `config/multicoin.php` with API credentials and settings

### Webhook Support
- **Controller**: `src/Http/Controllers/WebhookController.php` - Handles incoming webhooks
- **Middleware**: `src/Http/Middlewares/VerifySignature.php` - Validates webhook signatures
- **WebhookCall**: `src/WebhookCall.php` - Webhook data model

## Key Configuration

The library requires these configuration values (set in `config/multicoin.php` for Laravel or passed directly):

```php
[
    'api_token' => 'your-api-token',  // Required: Bearer token for authentication
    'url' => 'https://api.example.com/api/v1/',  // Required: Base API endpoint
    'coin' => 'BTC',  // Required: Default cryptocurrency
    'currency' => ['BTC', 'TBTC', 'LTC']  // Supported currencies
]
```

## Common Development Patterns

### Adding New API Endpoints
1. Create a new trait in `src/Traits/` if it's a new domain
2. Use the `buildUrl()` method to construct endpoint URLs with currency prefix
3. Use `buildQueryParam()` to merge default and custom parameters
4. Call API via `$this->client->doGet()` or `$this->client->doPost()`

### Error Handling
- The library uses `Http\Client\Common\Plugin\ErrorPlugin` for automatic error handling
- Custom exceptions in `src/Exceptions/` for specific error cases
- HTTP client errors are caught and wrapped appropriately

### Testing Approach
- Unit tests use `php-http/mock-client` for mocking HTTP responses
- Integration tests can use real API endpoints (configure test credentials)
- Tests extend `TestbenchTestCase` for Laravel package testing support

## Dependencies & Requirements

- PHP 7.1+ or 8.0+
- PSR-7/PSR-18 compatible HTTP client (auto-discovered)
- Laravel 9.x, 10.x, 11.x, or 12.x (optional, for Laravel integration)
- Key packages: php-http/httplug, php-http/discovery, guzzlehttp/guzzle7-adapter