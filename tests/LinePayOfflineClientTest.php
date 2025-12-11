<?php

declare(strict_types=1);

namespace LinePay\Offline\Tests;

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
}
