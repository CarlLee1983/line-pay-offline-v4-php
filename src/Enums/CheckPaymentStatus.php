<?php

declare(strict_types=1);

namespace LinePay\Offline\Enums;

/**
 * Check payment status types.
 *
 * 用於 checkPaymentStatus API 回應的付款狀態。
 * 當付款請求發生逾時時，可使用此狀態來確認實際的付款結果。
 */
enum CheckPaymentStatus: string
{
    /**
     * 付款完成。
     * 表示付款已成功處理。
     */
    case COMPLETE = 'COMPLETE';

    /**
     * 付款失敗。
     * 表示付款處理失敗，可能原因包括餘額不足、卡片問題等。
     */
    case FAIL = 'FAIL';

    /**
     * 已退款。
     * 表示付款已完成但後續已進行退款。
     */
    case REFUND = 'REFUND';
}
