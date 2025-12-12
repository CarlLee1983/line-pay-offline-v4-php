# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.1] - 2025-12-12

### Improved

- Enhanced internationalization (i18n) documentation
  - Added "Common Pitfalls & Troubleshooting" section to all README files (EN/ZH/JA/TH)
  - Added Laravel Package Discovery description
  - Updated Best Practices to reference troubleshooting section
  - Synchronized content across all language versions

### Fixed

- Fixed PHPStan errors in `ServiceProviderTest` and `LinePayOfflineServiceProvider`
- Improved code quality and static analysis compliance

### Documentation

- Enhanced README files with comprehensive troubleshooting guide
- Improved multi-language documentation consistency
- Added package discovery instructions for Laravel users

## [1.2.0] - 2025-01-12

### Added

- Enhanced parameter validation for `requestPayment()` method
  - Validates required parameters: `amount`, `currency`, `oneTimeKey`, `orderId`
  - Validates `amount` must be a positive integer
- Enhanced validation for `queryAuthorizations()` and `retrievePaymentDetails()`
  - Requires at least one of `orderId` or `transactionId` to be provided
  - Validates parameters are not empty strings
- Enhanced configuration validation in `LinePayOfflineConfig`
  - Validates `channelId` and `channelSecret` cannot be empty
  - Validates `merchantDeviceType` must be one of: `POS`, `KIOSK`
- Enhanced configuration validation in `LinePayOfflineServiceProvider`
  - Provides clear error messages for missing configuration
  - Validates configuration before creating client instance

### Improved

- Enhanced error messages for better debugging experience
- Added comprehensive PHPDoc comments to all Enum classes
- Improved code robustness with additional validation layers

### Testing

- Added 21 new test cases covering all validation scenarios
- Test suite expanded from 17 to 38 tests (85 assertions)
- 100% test coverage for all validation logic

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

[Unreleased]: https://github.com/CarlLee1983/line-pay-offline-v4-php/compare/v1.2.1...HEAD
[1.2.1]: https://github.com/CarlLee1983/line-pay-offline-v4-php/compare/v1.2.0...v1.2.1
[1.2.0]: https://github.com/CarlLee1983/line-pay-offline-v4-php/compare/v1.1.0...v1.2.0
[1.0.0]: https://github.com/CarlLee1983/line-pay-offline-v4-php/releases/tag/v1.0.0
