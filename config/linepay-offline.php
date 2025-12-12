<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | LINE Pay Channel ID
    |--------------------------------------------------------------------------
    |
    | Your LINE Pay Channel ID from the LINE Pay Merchant Center.
    |
    */
    'channel_id' => env('LINE_PAY_CHANNEL_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | LINE Pay Channel Secret
    |--------------------------------------------------------------------------
    |
    | Your LINE Pay Channel Secret from the LINE Pay Merchant Center.
    |
    */
    'channel_secret' => env('LINE_PAY_CHANNEL_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Merchant Device Profile ID
    |--------------------------------------------------------------------------
    |
    | The unique identifier for your POS/terminal device.
    | This is required for offline payment processing.
    |
    */
    'merchant_device_profile_id' => env('LINE_PAY_MERCHANT_DEVICE_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Merchant Device Type
    |--------------------------------------------------------------------------
    |
    | The type of your merchant device.
    |
    | Supported: "POS", "KIOSK", etc.
    |
    */
    'merchant_device_type' => env('LINE_PAY_MERCHANT_DEVICE_TYPE', 'POS'),

    /*
    |--------------------------------------------------------------------------
    | Environment
    |--------------------------------------------------------------------------
    |
    | The LINE Pay API environment. Use 'sandbox' for testing and
    | 'production' for live transactions.
    |
    | Supported: "sandbox", "production"
    |
    */
    'env' => env('LINE_PAY_ENV', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | The timeout in seconds for API requests.
    | Offline API may take up to 40 seconds for payment requests.
    |
    */
    'timeout' => env('LINE_PAY_TIMEOUT', 40),
];
