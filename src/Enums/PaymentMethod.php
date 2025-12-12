<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Payment method types.
 *
 * LINE Pay 支援的付款方式。
 * 用於識別付款時使用的資金來源。
 */
enum PaymentMethod: string
{
    /**
     * 信用卡付款。
     * 使用綁定的信用卡進行付款。
     */
    case CREDIT_CARD = 'CREDIT_CARD';

    /**
     * LINE Pay 餘額付款。
     * 使用 LINE Pay 帳戶餘額進行付款。
     */
    case BALANCE = 'BALANCE';

    /**
     * LINE Points 點數付款。
     * 使用 LINE Points 進行付款。
     */
    case POINT = 'POINT';

    /**
     * 折扣/優惠。
     * 使用優惠券或折扣進行付款。
     */
    case DISCOUNT = 'DISCOUNT';
}
