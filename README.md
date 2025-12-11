# LINE Pay Offline V4 PHP SDK

Modern, type-safe LINE Pay Offline V4 API SDK for PHP.

[繁體中文](./README_ZH.md) | English

## Features

- ✅ PHP 8.1+ with strict types
- ✅ PSR-4 autoloading
- ✅ POS/Kiosk payment support
- ✅ Type-safe enums for currencies and statuses
- ✅ Full PHPDoc documentation
- ✅ PHPStan Level Max static analysis
- ✅ Depends on `carllee/line-pay-core-v4`

## Requirements

- PHP 8.1 or higher
- Composer
- ext-json
- ext-openssl

## Installation

```bash
composer require carllee/line-pay-offline-v4
```

## Quick Start

```php
use LinePay\Offline\Config\LinePayOfflineConfig;
use LinePay\Offline\LinePayOfflineClient;
use LinePay\Offline\Enums\Currency;

// Create configuration
$config = new LinePayOfflineConfig(
    channelId: getenv('LINE_PAY_CHANNEL_ID'),
    channelSecret: getenv('LINE_PAY_CHANNEL_SECRET'),
    merchantDeviceProfileId: 'POS-001',
    merchantDeviceType: 'POS',
    env: 'sandbox'
);

// Create client
$client = new LinePayOfflineClient($config);

// Request payment with customer's barcode
$response = $client->requestPayment([
    'amount' => 100,
    'currency' => 'TWD',
    'oneTimeKey' => '12345678901245678', // From customer's LINE Pay barcode
    'orderId' => 'ORDER-' . time(),
]);

echo "Transaction ID: " . $response['info']['transactionId'];
```

## API Methods

### Request Payment
```php
$response = $client->requestPayment([
    'amount' => 100,
    'currency' => 'TWD',
    'oneTimeKey' => '12345678901245678',
    'orderId' => 'ORDER-001',
    'packages' => [
        [
            'id' => 'PKG-001',
            'amount' => 100,
            'products' => [
                ['name' => 'Coffee', 'quantity' => 1, 'price' => 100]
            ]
        ]
    ]
]);
```

### Check Payment Status
```php
$status = $client->checkPaymentStatus('ORDER-001');
// Returns: COMPLETE, FAIL, or REFUND
```

### Capture Payment
```php
$response = $client->capturePayment(
    orderId: 'ORDER-001',
    amount: 100,
    currency: Currency::TWD
);
```

### Void Authorization
```php
$response = $client->voidAuthorization('ORDER-001');
```

### Refund Payment
```php
// Full refund
$response = $client->refundPayment('ORDER-001');

// Partial refund
$response = $client->refundPayment('ORDER-001', 50);
```

### Query Authorizations
```php
$auths = $client->queryAuthorizations(orderId: 'ORDER-001');
```

### Retrieve Payment Details
```php
$details = $client->retrievePaymentDetails(orderId: 'ORDER-001');
```

## Error Handling

```php
use LinePay\Core\Errors\LinePayError;
use LinePay\Core\Errors\LinePayTimeoutError;

try {
    $response = $client->requestPayment($request);
} catch (LinePayTimeoutError $e) {
    // Timeout - check payment status
    $status = $client->checkPaymentStatus($orderId);
} catch (LinePayError $e) {
    echo "Error: " . $e->getReturnCode() . " - " . $e->getReturnMessage();
}
```

## Testing

```bash
composer install
composer test
```

## License

MIT License - see [LICENSE](LICENSE) for details.

## Resources

- [LINE Pay Offline API Documentation](https://pay.line.me/documents/offline.html)
- [LINE Pay Merchant Center](https://pay.line.me/portal/tw/)
