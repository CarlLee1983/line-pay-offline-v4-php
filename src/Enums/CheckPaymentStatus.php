<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Check payment status types.
 */
enum CheckPaymentStatus: string
{
    case COMPLETE = 'COMPLETE';
    case FAIL = 'FAIL';
    case REFUND = 'REFUND';
}
