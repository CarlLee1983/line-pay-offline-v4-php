<?php

declare(strict_types=1);

namespace LinePay\Offline;

use InvalidArgumentException;
use LinePay\Core\LinePayBaseClient;
use LinePay\Core\LinePayUtils;
use LinePay\Offline\Config\LinePayOfflineConfig;
use LinePay\Offline\Enums\Currency;

/**
 * LINE Pay Offline Client.
 *
 * Client for LINE Pay Offline API v4.
 * Handles payments through merchant terminal devices (POS systems).
 *
 * **Key Features:**
 * - ✅ Payment Request (Pay with oneTimeKey)
 * - ✅ Check Payment Status
 * - ✅ Query Authorization Information
 * - ✅ Capture Payment
 * - ✅ Void Authorization
 * - ✅ Retrieve Payment Details
 * - ✅ Refund
 *
 * @example
 * ```php
 * $config = new LinePayOfflineConfig(
 *     channelId: getenv('LINE_PAY_CHANNEL_ID'),
 *     channelSecret: getenv('LINE_PAY_CHANNEL_SECRET'),
 *     merchantDeviceProfileId: 'POS-001',
 *     merchantDeviceType: 'POS',
 *     env: 'sandbox'
 * );
 *
 * $client = new LinePayOfflineClient($config);
 *
 * // Request payment with oneTimeKey (from customer's barcode)
 * $payment = $client->requestPayment([
 *     'amount' => 100,
 *     'currency' => 'TWD',
 *     'oneTimeKey' => '12345678901245678',
 *     'orderId' => 'ORDER-001'
 * ]);
 * ```
 */
class LinePayOfflineClient extends LinePayBaseClient
{
    /**
     * Merchant Device Profile ID.
     */
    private readonly string $merchantDeviceProfileId;

    /**
     * Merchant Device Type.
     */
    private readonly string $merchantDeviceType;

    /**
     * Creates a new LinePayOfflineClient instance.
     *
     * @param LinePayOfflineConfig $config Offline client configuration
     */
    public function __construct(LinePayOfflineConfig $config)
    {
        parent::__construct($config->baseConfig);

        $this->merchantDeviceProfileId = $config->merchantDeviceProfileId;
        $this->merchantDeviceType = $config->merchantDeviceType;
    }

    /**
     * Get device-specific headers for offline API requests.
     *
     * @return array<string, string> Headers with device information
     */
    private function getDeviceHeaders(): array
    {
        return [
            'X-LINE-MerchantDeviceProfileId' => $this->merchantDeviceProfileId,
            'X-LINE-MerchantDeviceType' => $this->merchantDeviceType,
        ];
    }

    /**
     * Request Payment.
     *
     * Request payment using customer's one-time barcode.
     * The payment is completed after this API call (unless capture is separated).
     *
     * @param array<string, mixed> $request Payment request data
     *                                      Required keys: amount, currency, oneTimeKey, orderId
     *
     * @return array<string, mixed> Payment response with transaction ID
     *
     * @throws InvalidArgumentException If required parameters are missing or invalid
     */
    public function requestPayment(array $request): array
    {
        // 驗證必要參數
        if (!isset($request['amount']) || !is_int($request['amount']) || $request['amount'] <= 0) {
            throw new InvalidArgumentException('amount is required and must be a positive integer');
        }

        if (!isset($request['currency']) || !is_string($request['currency']) || trim($request['currency']) === '') {
            throw new InvalidArgumentException('currency is required and cannot be empty');
        }

        if (!isset($request['oneTimeKey']) || !is_string($request['oneTimeKey']) || trim($request['oneTimeKey']) === '') {
            throw new InvalidArgumentException('oneTimeKey is required and cannot be empty');
        }

        if (!isset($request['orderId']) || !is_string($request['orderId']) || trim($request['orderId']) === '') {
            throw new InvalidArgumentException('orderId is required and cannot be empty');
        }

        return $this->sendRequest(
            'POST',
            '/v4/payments/oneTimeKeys/pay',
            $request,
            null,
            $this->getDeviceHeaders()
        );
    }

    /**
     * Check Payment Status.
     *
     * Query payment status by order ID.
     * Use this when read timeout occurs during payment request.
     *
     * @param string $orderId Merchant order ID
     *
     * @return array<string, mixed> Payment status information
     */
    public function checkPaymentStatus(string $orderId): array
    {
        $encodedOrderId = urlencode($orderId);

        return $this->sendRequest(
            'GET',
            '/v4/payments/orders/' . $encodedOrderId . '/check',
            null,
            null,
            $this->getDeviceHeaders()
        );
    }

    /**
     * Query Authorization Information.
     *
     * Query authorized or voided authorization details.
     *
     * @param string|null $orderId       Merchant order ID
     * @param string|null $transactionId Transaction ID
     *
     * @return array<string, mixed> Array of authorization information
     *
     * @throws InvalidArgumentException If both orderId and transactionId are null
     */
    public function queryAuthorizations(?string $orderId = null, ?string $transactionId = null): array
    {
        $params = [];

        if ($orderId !== null) {
            if (trim($orderId) === '') {
                throw new InvalidArgumentException('orderId cannot be empty');
            }
            $params['orderId'] = $orderId;
        }

        if ($transactionId !== null) {
            if (trim($transactionId) === '') {
                throw new InvalidArgumentException('transactionId cannot be empty');
            }
            LinePayUtils::validateTransactionId($transactionId);
            $params['transactionId'] = $transactionId;
        }

        if (empty($params)) {
            throw new InvalidArgumentException('Either orderId or transactionId must be provided');
        }

        return $this->sendRequest(
            'GET',
            '/v4/payments/authorizations',
            null,
            $params,
            $this->getDeviceHeaders()
        );
    }

    /**
     * Capture Payment.
     *
     * Execute capture for separated authorization and capture flow.
     *
     * @param string         $orderId  Merchant order ID
     * @param int            $amount   Capture amount
     * @param Currency|string $currency Currency code
     *
     * @return array<string, mixed> Capture response with transaction details
     */
    public function capturePayment(string $orderId, int $amount, Currency|string $currency): array
    {
        $encodedOrderId = urlencode($orderId);
        $currencyValue = $currency instanceof Currency ? $currency->value : $currency;

        return $this->sendRequest(
            'POST',
            '/v4/payments/orders/' . $encodedOrderId . '/capture',
            [
                'amount' => $amount,
                'currency' => $currencyValue,
            ],
            null,
            $this->getDeviceHeaders()
        );
    }

    /**
     * Void Authorization.
     *
     * Cancel authorized payment before capture.
     *
     * @param string $orderId Merchant order ID
     *
     * @return array<string, mixed> Void response
     */
    public function voidAuthorization(string $orderId): array
    {
        $encodedOrderId = urlencode($orderId);

        return $this->sendRequest(
            'POST',
            '/v4/payments/orders/' . $encodedOrderId . '/void',
            [],
            null,
            $this->getDeviceHeaders()
        );
    }

    /**
     * Retrieve Payment Details.
     *
     * Query captured or authorized payment details.
     *
     * @param string|null $orderId       Merchant order ID
     * @param string|null $transactionId Transaction ID
     *
     * @return array<string, mixed> Array of payment details
     *
     * @throws InvalidArgumentException If both orderId and transactionId are null
     */
    public function retrievePaymentDetails(?string $orderId = null, ?string $transactionId = null): array
    {
        $params = [];

        if ($orderId !== null) {
            if (trim($orderId) === '') {
                throw new InvalidArgumentException('orderId cannot be empty');
            }
            $params['orderId'] = $orderId;
        }

        if ($transactionId !== null) {
            if (trim($transactionId) === '') {
                throw new InvalidArgumentException('transactionId cannot be empty');
            }
            LinePayUtils::validateTransactionId($transactionId);
            $params['transactionId'] = $transactionId;
        }

        if (empty($params)) {
            throw new InvalidArgumentException('Either orderId or transactionId must be provided');
        }

        return $this->sendRequest(
            'GET',
            '/v4/payments',
            null,
            $params,
            $this->getDeviceHeaders()
        );
    }

    /**
     * Refund Payment.
     *
     * Refund completed payment (after capture).
     * Supports both partial and full refund.
     *
     * @param string   $orderId      Merchant order ID
     * @param int|null $refundAmount Refund amount (optional, null for full refund)
     *
     * @return array<string, mixed> Refund response with refund transaction ID
     */
    public function refundPayment(string $orderId, ?int $refundAmount = null): array
    {
        $encodedOrderId = urlencode($orderId);

        $body = [];
        if ($refundAmount !== null) {
            $body['refundAmount'] = $refundAmount;
        }

        return $this->sendRequest(
            'POST',
            '/v4/payments/orders/' . $encodedOrderId . '/refund',
            $body,
            null,
            $this->getDeviceHeaders()
        );
    }
}
