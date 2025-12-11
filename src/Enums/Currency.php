<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Currency codes (ISO 4217).
 *
 * Supported currencies for LINE Pay Offline API.
 */
enum Currency: string
{
    case USD = 'USD';
    case TWD = 'TWD';
    case THB = 'THB';
    case JPY = 'JPY';
}
