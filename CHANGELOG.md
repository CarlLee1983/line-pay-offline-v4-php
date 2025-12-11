# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2024-12-11

### Added

- Initial release of LINE Pay Offline V4 PHP SDK
- `LinePayOfflineClient` - Main client for Offline API
- API Methods:
  - `requestPayment()` - Request payment with oneTimeKey
  - `checkPaymentStatus()` - Check payment status
  - `queryAuthorizations()` - Query authorization info
  - `capturePayment()` - Capture authorized payment
  - `voidAuthorization()` - Void authorization
  - `retrievePaymentDetails()` - Get payment details
  - `refundPayment()` - Refund payment
- Configuration:
  - `LinePayOfflineConfig` - Offline-specific configuration
  - Support for merchantDeviceProfileId and merchantDeviceType
- Enums (PHP 8.1+):
  - `Currency` - Currency codes
  - `PaymentMethod` - Payment methods
  - `PaymentProvider` - Provider types
  - `PaymentStatus` - Authorization statuses
  - `CheckPaymentStatus` - Check status types
- Comprehensive test suite (13 tests, 30 assertions)
- PHPStan Level Max static analysis
- Multi-language documentation (EN/ZH)
- GitHub Actions CI/CD workflows

### Dependencies

- Requires `carllee/line-pay-core-v4` ^1.0
- PHP 8.1+ required

[Unreleased]: https://github.com/CarlLee1983/line-pay-offline-v4-php/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/CarlLee1983/line-pay-offline-v4-php/releases/tag/v1.0.0
