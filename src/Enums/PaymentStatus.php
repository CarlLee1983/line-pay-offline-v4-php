<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Payment status for authorization queries.
 *
 * 用於 queryAuthorizations API 的授權狀態。
 * 表示授權交易的當前狀態。
 */
enum PaymentStatus: string
{
    /**
     * 已授權。
     * 付款已授權但尚未完成 capture（請款）。
     * 可後續執行 capture 或 void 操作。
     */
    case AUTHORIZATION = 'AUTHORIZATION';

    /**
     * 已取消授權。
     * 授權已被取消（void），不會進行請款。
     */
    case VOIDED_AUTHORIZATION = 'VOIDED_AUTHORIZATION';

    /**
     * 授權已過期。
     * 授權已超過有效期限，無法再進行 capture。
     */
    case EXPIRED_AUTHORIZATION = 'EXPIRED_AUTHORIZATION';
}
