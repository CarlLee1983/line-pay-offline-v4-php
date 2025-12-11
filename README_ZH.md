# LINE Pay Offline V4 PHP SDK

現代化、類型安全的 LINE Pay Offline V4 API PHP SDK。

繁體中文 | [English](./README.md)

## 功能特色

- ✅ PHP 8.1+ 嚴格類型
- ✅ PSR-4 自動載入
- ✅ POS/Kiosk 付款支援
- ✅ 類型安全的枚舉（貨幣、狀態）
- ✅ 完整 PHPDoc 文件
- ✅ PHPStan Level Max 靜態分析
- ✅ 依賴 `carllee/line-pay-core-v4`

## 系統需求

- PHP 8.1 或更高版本
- Composer
- ext-json
- ext-openssl

## 安裝

```bash
composer require carllee/line-pay-offline-v4
```

## 快速開始

```php
use LinePay\Offline\Config\LinePayOfflineConfig;
use LinePay\Offline\LinePayOfflineClient;
use LinePay\Offline\Enums\Currency;

// 建立設定
$config = new LinePayOfflineConfig(
    channelId: getenv('LINE_PAY_CHANNEL_ID'),
    channelSecret: getenv('LINE_PAY_CHANNEL_SECRET'),
    merchantDeviceProfileId: 'POS-001',
    merchantDeviceType: 'POS',
    env: 'sandbox'
);

// 建立客戶端
$client = new LinePayOfflineClient($config);

// 使用客戶條碼請求付款
$response = $client->requestPayment([
    'amount' => 100,
    'currency' => 'TWD',
    'oneTimeKey' => '12345678901245678', // 來自客戶 LINE Pay 條碼
    'orderId' => 'ORDER-' . time(),
]);

echo "交易 ID: " . $response['info']['transactionId'];
```

## API 方法

### 請求付款
```php
$response = $client->requestPayment([
    'amount' => 100,
    'currency' => 'TWD',
    'oneTimeKey' => '12345678901245678',
    'orderId' => 'ORDER-001',
    'packages' => [
        [
            'id' => 'PKG-001',
            'amount' => 100,
            'products' => [
                ['name' => '咖啡', 'quantity' => 1, 'price' => 100]
            ]
        ]
    ]
]);
```

### 檢查付款狀態
```php
$status = $client->checkPaymentStatus('ORDER-001');
// 回傳: COMPLETE, FAIL, 或 REFUND
```

### 請款
```php
$response = $client->capturePayment(
    orderId: 'ORDER-001',
    amount: 100,
    currency: Currency::TWD
);
```

### 取消授權
```php
$response = $client->voidAuthorization('ORDER-001');
```

### 退款
```php
// 全額退款
$response = $client->refundPayment('ORDER-001');

// 部分退款
$response = $client->refundPayment('ORDER-001', 50);
```

### 查詢授權
```php
$auths = $client->queryAuthorizations(orderId: 'ORDER-001');
```

### 查詢付款詳情
```php
$details = $client->retrievePaymentDetails(orderId: 'ORDER-001');
```

## 錯誤處理

```php
use LinePay\Core\Errors\LinePayError;
use LinePay\Core\Errors\LinePayTimeoutError;

try {
    $response = $client->requestPayment($request);
} catch (LinePayTimeoutError $e) {
    // 逾時 - 檢查付款狀態
    $status = $client->checkPaymentStatus($orderId);
} catch (LinePayError $e) {
    echo "錯誤: " . $e->getReturnCode() . " - " . $e->getReturnMessage();
}
```

## 測試

```bash
composer install
composer test
```

## 授權

MIT 授權 - 詳見 [LICENSE](LICENSE)。

## 資源

- [LINE Pay Offline API 文件](https://pay.line.me/documents/offline.html)
- [LINE Pay 商家後台](https://pay.line.me/portal/tw/)
