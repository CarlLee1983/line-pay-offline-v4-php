# Contributing to LINE Pay Offline V4 PHP SDK

Thank you for considering contributing to this project! 🎉

[繁體中文版](CONTRIBUTING_ZH.md)

## Code of Conduct

By participating in this project, you agree to maintain a respectful and inclusive environment.

## How to Contribute

### Reporting Bugs

1. Check if the bug has already been reported in [Issues](https://github.com/CarlLee1983/line-pay-offline-v4-php/issues)
2. If not, create a new issue using the Bug Report template
3. Include:
   - Clear description
   - Steps to reproduce
   - Expected vs actual behavior
   - PHP version and environment

### Suggesting Features

1. Check existing [Issues](https://github.com/CarlLee1983/line-pay-offline-v4-php/issues) and [Discussions](https://github.com/CarlLee1983/line-pay-offline-v4-php/discussions)
2. Create a Feature Request issue with:
   - Problem description
   - Proposed solution
   - Use case examples

### Pull Requests

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature-name`
3. Make your changes
4. Run tests and checks:
   ```bash
   composer test
   composer analyze
   composer lint
   ```
5. Commit with a descriptive message
6. Push and create a Pull Request

## Development Setup

### Prerequisites

- PHP 8.1 or higher
- Composer

### Installation

```bash
# Clone your fork
git clone https://github.com/YOUR_USERNAME/line-pay-offline-v4-php.git
cd line-pay-offline-v4-php

# Install dependencies
composer install
```

### Running Tests

```bash
# Run all tests
composer test

# Run static analysis
composer analyze

# Check code style
composer lint

# Fix code style
composer lint:fix
```

## Coding Standards

### PHP Style

- Follow PSR-12 coding standards
- Use PHP 8.1+ features (enums, readonly, named arguments)
- Add type declarations for all parameters and return types
- Write comprehensive PHPDoc comments

### Example

```php
<?php

declare(strict_types=1);

namespace LinePay\Offline;

/**
 * Example class demonstrating coding standards.
 */
class Example
{
    /**
     * Create a new instance.
     *
     * @param string $name The name parameter
     * @param int    $value The value parameter
     */
    public function __construct(
        public readonly string $name,
        public readonly int $value
    ) {
    }

    /**
     * Process the data.
     *
     * @return array<string, mixed> The processed result
     */
    public function process(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
```

### Commit Messages

Follow conventional commits:

- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation only
- `style:` Code style changes
- `refactor:` Code refactoring
- `test:` Adding tests
- `chore:` Maintenance tasks

Example: `feat: add support for batch refunds`

### Testing

- Write tests for all new features
- Maintain or improve code coverage
- Use descriptive test method names

```php
public function testRequestPaymentWithValidOneTimeKey(): void
{
    // Arrange
    $oneTimeKey = '12345678901234567';
    
    // Act
    // ...
    
    // Assert
    $this->assertEquals('0000', $response['returnCode']);
}
```

## Project Structure

```
line-pay-offline-v4-php/
├── src/
│   ├── Config/              # Configuration classes
│   ├── Enums/               # PHP 8.1 enums
│   └── LinePayOfflineClient.php # Main client
├── tests/                   # PHPUnit tests
├── .github/                 # GitHub configurations
└── composer.json
```

## Questions?

- Open a [Discussion](https://github.com/CarlLee1983/line-pay-offline-v4-php/discussions)
- Check existing issues and documentation

Thank you for contributing! 🙏
