<?php

declare(strict_types=1);

namespace LinePay\Offline\Laravel;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use LinePay\Offline\Config\LinePayOfflineConfig;
use LinePay\Offline\LinePayOfflineClient;

/**
 * LINE Pay Offline Service Provider for Laravel.
 *
 * Registers LinePayOfflineClient as a singleton in the Laravel IoC container.
 *
 * @example
 * ```php
 * // In a controller or service
 * public function __construct(private LinePayOfflineClient $linePay) {}
 *
 * // Or using the facade
 * LinePayOffline::requestPayment($request);
 * ```
 */
class LinePayOfflineServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the LINE Pay Offline services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/linepay-offline.php',
            'linepay-offline'
        );

        $this->app->singleton(LinePayOfflineClient::class, function (Application $app): LinePayOfflineClient {
            /** @var \Illuminate\Config\Repository $configRepo */
            $configRepo = $app->make('config');

            /** @var array{channel_id?: string, channel_secret?: string, merchant_device_profile_id?: string, merchant_device_type?: string, env?: string, timeout?: int} $config */
            $config = $configRepo->get('linepay-offline', []);

            $linePayConfig = new LinePayOfflineConfig(
                channelId: $config['channel_id'] ?? '',
                channelSecret: $config['channel_secret'] ?? '',
                merchantDeviceProfileId: $config['merchant_device_profile_id'] ?? '',
                merchantDeviceType: $config['merchant_device_type'] ?? 'POS',
                env: $config['env'] ?? 'sandbox',
                timeout: $config['timeout'] ?? 40
            );

            return new LinePayOfflineClient($linePayConfig);
        });

        $this->app->alias(LinePayOfflineClient::class, 'linepay-offline');
    }

    /**
     * Bootstrap the LINE Pay Offline services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/linepay-offline.php' => $this->app->configPath('linepay-offline.php'),
            ], 'linepay-offline-config');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            LinePayOfflineClient::class,
            'linepay-offline',
        ];
    }
}
