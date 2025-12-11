# Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| 1.x.x   | :white_check_mark: |

## Reporting a Vulnerability

We take security issues seriously. If you discover a security vulnerability, please report it responsibly.

### How to Report

1. **DO NOT** create a public GitHub issue for security vulnerabilities
2. Email your report to: carllee1983@gmail.com
3. Include as much detail as possible:
   - Description of the vulnerability
   - Steps to reproduce
   - Potential impact
   - Suggested fix (if any)

### What to Expect

- **Response Time**: We aim to acknowledge your report within 48 hours
- **Updates**: We will keep you informed of our progress
- **Resolution**: We will notify you when the issue is fixed
- **Credit**: We will credit you in the release notes (unless you prefer anonymity)

## Security Best Practices

When using this SDK, follow these security practices:

### 1. Protect Your Credentials

```php
// ✅ Use environment variables
$config = new LinePayOfflineConfig(
    channelId: getenv('LINE_PAY_CHANNEL_ID'),
    channelSecret: getenv('LINE_PAY_CHANNEL_SECRET'),
    merchantDeviceProfileId: getenv('MERCHANT_DEVICE_ID')
);

// ❌ Never hardcode credentials
$config = new LinePayOfflineConfig(
    channelId: '1234567890',
    channelSecret: 'your-secret-key',
    merchantDeviceProfileId: 'POS-001'
);
```

### 2. Validate One-Time Keys

Always validate that the oneTimeKey is from a legitimate source (customer's LINE Pay barcode):

```php
// Validate oneTimeKey format before payment
if (!preg_match('/^\d{17,20}$/', $oneTimeKey)) {
    throw new Exception('Invalid oneTimeKey format');
}
```

### 3. Verify Payment Status

After timeout, always verify payment status:

```php
try {
    $response = $client->requestPayment($request);
} catch (LinePayTimeoutError $e) {
    // Always check status after timeout
    $status = $client->checkPaymentStatus($orderId);
    // Handle based on actual status
}
```

### 4. Handle Errors Securely

Don't expose internal error details to end users:

```php
try {
    $response = $client->requestPayment($request);
} catch (LinePayError $e) {
    // Log the full error internally
    error_log($e->getMessage());
    
    // Show generic message to customer
    return response()->json([
        'error' => 'Payment processing failed'
    ], 400);
}
```

## Dependencies

This SDK depends on:
- `carllee/line-pay-core-v4`: Core functionality
- `guzzlehttp/guzzle`: HTTP client

We regularly update dependencies to address security vulnerabilities.

## Security Updates

Security fixes are released as patch versions and announced in:
- GitHub Release notes
- CHANGELOG.md
