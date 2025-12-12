<?php

declare(strict_types=1);

namespace LinePay\Offline\Tests;

use InvalidArgumentException;
use LinePay\Offline\Config\LinePayOfflineConfig;
use LinePay\Offline\LinePayOfflineClient;
use PHPUnit\Framework\TestCase;

class LinePayOfflineClientTest extends TestCase
{
    private LinePayOfflineClient $client;

    protected function setUp(): void
    {
        $config = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001',
            merchantDeviceType: 'POS',
            env: 'sandbox'
        );

        $this->client = new LinePayOfflineClient($config);
    }

    public function testClientInitialization(): void
    {
        $this->assertInstanceOf(LinePayOfflineClient::class, $this->client);
    }

    public function testClientWithDifferentDeviceType(): void
    {
        $config = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'KIOSK-001',
            merchantDeviceType: 'KIOSK',
            env: 'sandbox'
        );

        $client = new LinePayOfflineClient($config);
        $this->assertInstanceOf(LinePayOfflineClient::class, $client);
    }

    public function testClientWithProductionEnv(): void
    {
        $config = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001',
            env: 'production'
        );

        $client = new LinePayOfflineClient($config);
        $this->assertInstanceOf(LinePayOfflineClient::class, $client);
    }

    public function testRequestPaymentMissingAmountThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('amount is required');

        $this->client->requestPayment([
            'currency' => 'TWD',
            'oneTimeKey' => '12345678901234567',
            'orderId' => 'ORDER-001',
        ]);
    }

    public function testRequestPaymentInvalidAmountThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('amount is required');

        $this->client->requestPayment([
            'amount' => 0,
            'currency' => 'TWD',
            'oneTimeKey' => '12345678901234567',
            'orderId' => 'ORDER-001',
        ]);
    }

    public function testRequestPaymentMissingCurrencyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('currency is required');

        $this->client->requestPayment([
            'amount' => 100,
            'oneTimeKey' => '12345678901234567',
            'orderId' => 'ORDER-001',
        ]);
    }

    public function testRequestPaymentEmptyCurrencyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('currency is required');

        $this->client->requestPayment([
            'amount' => 100,
            'currency' => '   ',
            'oneTimeKey' => '12345678901234567',
            'orderId' => 'ORDER-001',
        ]);
    }

    public function testRequestPaymentMissingOneTimeKeyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('oneTimeKey is required');

        $this->client->requestPayment([
            'amount' => 100,
            'currency' => 'TWD',
            'orderId' => 'ORDER-001',
        ]);
    }

    public function testRequestPaymentEmptyOneTimeKeyThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('oneTimeKey is required');

        $this->client->requestPayment([
            'amount' => 100,
            'currency' => 'TWD',
            'oneTimeKey' => '',
            'orderId' => 'ORDER-001',
        ]);
    }

    public function testRequestPaymentMissingOrderIdThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('orderId is required');

        $this->client->requestPayment([
            'amount' => 100,
            'currency' => 'TWD',
            'oneTimeKey' => '12345678901234567',
        ]);
    }

    public function testQueryAuthorizationsBothNullThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Either orderId or transactionId must be provided');

        $this->client->queryAuthorizations();
    }

    public function testQueryAuthorizationsEmptyOrderIdThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('orderId cannot be empty');

        $this->client->queryAuthorizations(orderId: '   ');
    }

    public function testRetrievePaymentDetailsBothNullThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Either orderId or transactionId must be provided');

        $this->client->retrievePaymentDetails();
    }

    public function testRetrievePaymentDetailsEmptyOrderIdThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('orderId cannot be empty');

        $this->client->retrievePaymentDetails(orderId: '   ');
    }
}
