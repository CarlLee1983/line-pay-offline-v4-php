<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Payment method types.
 */
enum PaymentMethod: string
{
    case CREDIT_CARD = 'CREDIT_CARD';
    case BALANCE = 'BALANCE';
    case POINT = 'POINT';
    case DISCOUNT = 'DISCOUNT';
}
