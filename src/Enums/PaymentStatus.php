<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Payment status for authorization queries.
 */
enum PaymentStatus: string
{
    case AUTHORIZATION = 'AUTHORIZATION';
    case VOIDED_AUTHORIZATION = 'VOIDED_AUTHORIZATION';
    case EXPIRED_AUTHORIZATION = 'EXPIRED_AUTHORIZATION';
}
