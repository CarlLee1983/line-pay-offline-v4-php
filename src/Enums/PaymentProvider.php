<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Payment provider types.
 *
 * LINE Pay 的付款服務提供者類型。
 * 用於識別處理付款的後端服務提供者。
 */
enum PaymentProvider: string
{
    /**
     * TSP (Transaction Service Provider).
     * 交易服務提供者。
     */
    case TSP = 'TSP';

    /**
     * PGW (Payment Gateway).
     * 付款閘道服務提供者。
     */
    case PGW = 'PGW';
}
