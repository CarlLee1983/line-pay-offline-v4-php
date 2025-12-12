<?php

declare(strict_types=1);

namespace LinePay\Offline\Laravel;

use Illuminate\Support\Facades\Facade;
use LinePay\Offline\LinePayOfflineClient;

/**
 * LINE Pay Offline Facade for Laravel.
 *
 * Provides static access to LinePayOfflineClient methods via Laravel's Facade system.
 *
 * @method static array<string, mixed> requestPayment(array<string, mixed> $request)
 * @method static array<string, mixed> checkPaymentStatus(string $orderId)
 * @method static array<string, mixed> queryAuthorizations(?string $orderId = null, ?string $transactionId = null)
 * @method static array<string, mixed> capturePayment(string $orderId, int $amount, \LinePay\Offline\Enums\Currency|string $currency)
 * @method static array<string, mixed> voidAuthorization(string $orderId)
 * @method static array<string, mixed> retrievePaymentDetails(?string $orderId = null, ?string $transactionId = null)
 * @method static array<string, mixed> refundPayment(string $orderId, ?int $refundAmount = null)
 *
 * @see \LinePay\Offline\LinePayOfflineClient
 */
class LinePayOffline extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return LinePayOfflineClient::class;
    }
}
