<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Payment provider types.
 */
enum PaymentProvider: string
{
    case TSP = 'TSP';
    case PGW = 'PGW';
}
