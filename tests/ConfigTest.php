<?php

declare(strict_types=1);

namespace LinePay\Offline\Tests;

use LinePay\Core\Errors\LinePayConfigError;
use LinePay\Offline\Config\LinePayOfflineConfig;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testValidConfig(): void
    {
        $config = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001',
            merchantDeviceType: 'POS',
            env: 'sandbox'
        );

        $this->assertEquals('test-channel-id', $config->getChannelId());
        $this->assertEquals('test-channel-secret', $config->getChannelSecret());
        $this->assertEquals('POS-001', $config->merchantDeviceProfileId);
        $this->assertEquals('POS', $config->merchantDeviceType);
        $this->assertEquals('sandbox', $config->getEnv());
    }

    public function testDefaultDeviceType(): void
    {
        $config = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'KIOSK-001'
        );

        $this->assertEquals('POS', $config->merchantDeviceType);
    }

    public function testEmptyMerchantDeviceProfileIdThrows(): void
    {
        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('merchantDeviceProfileId is required');

        new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: ''
        );
    }

    public function testWhitespaceMerchantDeviceProfileIdThrows(): void
    {
        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('merchantDeviceProfileId is required');

        new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: '   '
        );
    }

    public function testProductionEnvironment(): void
    {
        $config = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001',
            env: 'production'
        );

        $this->assertEquals('production', $config->getEnv());
    }

    public function testEmptyChannelIdThrows(): void
    {
        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('channelId is required');

        new LinePayOfflineConfig(
            channelId: '',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001'
        );
    }

    public function testWhitespaceChannelIdThrows(): void
    {
        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('channelId is required');

        new LinePayOfflineConfig(
            channelId: '   ',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001'
        );
    }

    public function testEmptyChannelSecretThrows(): void
    {
        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('channelSecret is required');

        new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: '',
            merchantDeviceProfileId: 'POS-001'
        );
    }

    public function testWhitespaceChannelSecretThrows(): void
    {
        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('channelSecret is required');

        new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: '   ',
            merchantDeviceProfileId: 'POS-001'
        );
    }

    public function testInvalidMerchantDeviceTypeThrows(): void
    {
        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('merchantDeviceType must be one of');

        new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001',
            merchantDeviceType: 'INVALID'
        );
    }

    public function testValidMerchantDeviceTypes(): void
    {
        $configPos = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'POS-001',
            merchantDeviceType: 'POS'
        );
        $this->assertEquals('POS', $configPos->merchantDeviceType);

        $configKiosk = new LinePayOfflineConfig(
            channelId: 'test-channel-id',
            channelSecret: 'test-channel-secret',
            merchantDeviceProfileId: 'KIOSK-001',
            merchantDeviceType: 'KIOSK'
        );
        $this->assertEquals('KIOSK', $configKiosk->merchantDeviceType);
    }
}
