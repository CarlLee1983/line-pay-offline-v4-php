<?php

declare(strict_types=1);

namespace LinePay\Offline\Config;

use LinePay\Core\Config\Env;
use LinePay\Core\Config\LinePayConfig;
use LinePay\Core\Errors\LinePayConfigError;

/**
 * LINE Pay Offline Client Configuration.
 *
 * Wraps the base configuration with offline-specific settings.
 */
class LinePayOfflineConfig
{
    /**
     * Base LINE Pay configuration.
     */
    public readonly LinePayConfig $baseConfig;

    /**
     * Merchant Device Profile ID.
     */
    public readonly string $merchantDeviceProfileId;

    /**
     * Merchant Device Type.
     */
    public readonly string $merchantDeviceType;

    /**
     * Create a new LinePayOfflineConfig instance.
     *
     * @param string $channelId               LINE Pay Channel ID
     * @param string $channelSecret           LINE Pay Channel Secret
     * @param string $merchantDeviceProfileId Merchant Device Profile ID (e.g., POS system ID)
     * @param string $merchantDeviceType      Merchant Device Type (default: "POS")
     * @param string $env                     Environment ("sandbox" or "production")
     * @param int    $timeout                 Request timeout in seconds
     *
     * @throws LinePayConfigError If required parameters are empty or invalid
     */
    public function __construct(
        string $channelId,
        string $channelSecret,
        string $merchantDeviceProfileId,
        string $merchantDeviceType = 'POS',
        string $env = 'sandbox',
        int $timeout = Env::DEFAULT_TIMEOUT
    ) {
        $channelId = trim($channelId);
        if ($channelId === '') {
            throw new LinePayConfigError('channelId is required and cannot be empty');
        }

        $channelSecret = trim($channelSecret);
        if ($channelSecret === '') {
            throw new LinePayConfigError('channelSecret is required and cannot be empty');
        }

        $merchantDeviceProfileId = trim($merchantDeviceProfileId);
        if ($merchantDeviceProfileId === '') {
            throw new LinePayConfigError('merchantDeviceProfileId is required and cannot be empty');
        }

        $merchantDeviceType = trim($merchantDeviceType);
        if ($merchantDeviceType === '') {
            $merchantDeviceType = 'POS';
        }

        // 驗證 merchantDeviceType 是否為有效值
        $validDeviceTypes = ['POS', 'KIOSK'];
        if (!in_array($merchantDeviceType, $validDeviceTypes, true)) {
            throw new LinePayConfigError(
                sprintf(
                    'merchantDeviceType must be one of: %s. Got: %s',
                    implode(', ', $validDeviceTypes),
                    $merchantDeviceType
                )
            );
        }

        $this->baseConfig = new LinePayConfig($channelId, $channelSecret, $env, $timeout);
        $this->merchantDeviceProfileId = $merchantDeviceProfileId;
        $this->merchantDeviceType = $merchantDeviceType;
    }

    /**
     * Get channel ID.
     */
    public function getChannelId(): string
    {
        return $this->baseConfig->channelId;
    }

    /**
     * Get channel secret.
     */
    public function getChannelSecret(): string
    {
        return $this->baseConfig->channelSecret;
    }

    /**
     * Get environment.
     */
    public function getEnv(): string
    {
        return $this->baseConfig->env;
    }
}
