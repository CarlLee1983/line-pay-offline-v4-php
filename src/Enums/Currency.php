<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Currency codes (ISO 4217).
 *
 * LINE Pay Offline API 支援的貨幣代碼。
 * 使用 ISO 4217 標準的三字母貨幣代碼。
 */
enum Currency: string
{
    /**
     * 美元 (United States Dollar).
     */
    case USD = 'USD';

    /**
     * 新台幣 (New Taiwan Dollar).
     */
    case TWD = 'TWD';

    /**
     * 泰銖 (Thai Baht).
     */
    case THB = 'THB';

    /**
     * 日圓 (Japanese Yen).
     */
    case JPY = 'JPY';
}
