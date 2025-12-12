<?php

declare(strict_types=1);

namespace LinePay\Offline\Tests\Laravel;

use Illuminate\Config\Repository;
use LinePay\Core\Errors\LinePayConfigError;
use LinePay\Offline\Laravel\LinePayOfflineServiceProvider;
use LinePay\Offline\LinePayOfflineClient;
use Orchestra\Testbench\TestCase;

class ServiceProviderTest extends TestCase
{
    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [LinePayOfflineServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        /** @var Repository $config */
        $config = $app['config'];
        $config->set('linepay-offline.channel_id', 'test-channel-id');
        $config->set('linepay-offline.channel_secret', 'test-channel-secret');
        $config->set('linepay-offline.merchant_device_profile_id', 'POS-001');
        $config->set('linepay-offline.merchant_device_type', 'POS');
        $config->set('linepay-offline.env', 'sandbox');
        $config->set('linepay-offline.timeout', 40);
    }

    public function testServiceProviderRegistersLinePayOfflineClient(): void
    {
        $app = $this->app;
        $this->assertNotNull($app);
        $this->assertTrue($app->bound(LinePayOfflineClient::class));
    }

    public function testLinePayOfflineClientIsSingleton(): void
    {
        $app = $this->app;
        $this->assertNotNull($app);

        $client1 = $app->make(LinePayOfflineClient::class);
        $client2 = $app->make(LinePayOfflineClient::class);

        $this->assertSame($client1, $client2);
    }

    public function testLinePayOfflineAlias(): void
    {
        $app = $this->app;
        $this->assertNotNull($app);

        $this->assertTrue($app->bound('linepay-offline'));

        $client = $app->make('linepay-offline');
        $this->assertInstanceOf(LinePayOfflineClient::class, $client);
    }

    public function testConfigIsLoaded(): void
    {
        $this->assertEquals('test-channel-id', config('linepay-offline.channel_id'));
        $this->assertEquals('test-channel-secret', config('linepay-offline.channel_secret'));
        $this->assertEquals('POS-001', config('linepay-offline.merchant_device_profile_id'));
        $this->assertEquals('POS', config('linepay-offline.merchant_device_type'));
        $this->assertEquals('sandbox', config('linepay-offline.env'));
        $this->assertEquals(40, config('linepay-offline.timeout'));
    }

    public function testMissingChannelIdThrows(): void
    {
        $app = $this->app;
        $this->assertNotNull($app);

        /** @var Repository $config */
        $config = $app->make('config');
        $config->set('linepay-offline.channel_id', '');

        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('Missing required LINE Pay Offline configuration');

        $app->make(LinePayOfflineClient::class);
    }

    public function testMissingChannelSecretThrows(): void
    {
        $app = $this->app;
        $this->assertNotNull($app);

        /** @var Repository $config */
        $config = $app->make('config');
        $config->set('linepay-offline.channel_secret', '');

        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('Missing required LINE Pay Offline configuration');

        $app->make(LinePayOfflineClient::class);
    }

    public function testMissingMerchantDeviceProfileIdThrows(): void
    {
        $app = $this->app;
        $this->assertNotNull($app);

        /** @var Repository $config */
        $config = $app->make('config');
        $config->set('linepay-offline.merchant_device_profile_id', '');

        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('Missing required LINE Pay Offline configuration');

        $app->make(LinePayOfflineClient::class);
    }

    public function testInvalidMerchantDeviceTypeThrows(): void
    {
        $app = $this->app;
        $this->assertNotNull($app);

        /** @var Repository $config */
        $config = $app->make('config');
        $config->set('linepay-offline.merchant_device_type', 'INVALID');

        $this->expectException(LinePayConfigError::class);
        $this->expectExceptionMessage('Invalid LINE Pay Offline configuration');

        $app->make(LinePayOfflineClient::class);
    }
}
