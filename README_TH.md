# LINE Pay Offline V4 PHP SDK

[![CI](https://github.com/CarlLee1983/line-pay-offline-v4-php/actions/workflows/ci.yml/badge.svg)](https://github.com/CarlLee1983/line-pay-offline-v4-php/actions/workflows/ci.yml)
[![PHP Version](https://img.shields.io/packagist/php-v/carllee/line-pay-offline-v4)](https://packagist.org/packages/carllee/line-pay-offline-v4)
[![License](https://img.shields.io/github/license/CarlLee1983/line-pay-offline-v4-php)](LICENSE)

LINE Pay Offline V4 API SDK สำหรับ PHP ที่ทันสมัยและปลอดภัยด้านประเภทข้อมูล

**🌐 Language / 語言 / 言語 / ภาษา:**
[English](./README.md) | [繁體中文](./README_ZH.md) | [日本語](./README_JA.md) | [ภาษาไทย](./README_TH.md)

## คุณสมบัติ

- ✅ **PHP 8.1+** พร้อม strict types และ enums
- ✅ **รองรับเครื่อง POS/Kiosk** - สำหรับร้านค้าปลีกและบริการอาหาร
- ✅ **ชำระเงินด้วย One-Time Key** - สแกนบาร์โค้ดของลูกค้า
- ✅ **ครอบคลุม API ทั้งหมด** - ชำระเงิน, capture, void, refund
- ✅ **Type-Safe Enums** - Currency, PaymentStatus ฯลฯ
- ✅ **PHPStan Level Max** - การวิเคราะห์แบบ static ที่เข้มงวด
- ✅ **PSR-4 Autoloading** - ใช้งานได้กับ Composer
- ✅ **สร้างบน Core SDK** - ใช้โค้ดร่วมกับ Online SDK

## ความต้องการ

- PHP 8.1 หรือสูงกว่า
- Composer
- ext-json
- ext-openssl

## การติดตั้ง

```bash
composer require carllee/line-pay-offline-v4
```

## เริ่มต้นใช้งาน

```php
<?php

use LinePay\Offline\Config\LinePayOfflineConfig;
use LinePay\Offline\LinePayOfflineClient;
use LinePay\Offline\Enums\Currency;

// สร้างการตั้งค่า
$config = new LinePayOfflineConfig(
    channelId: getenv('LINE_PAY_CHANNEL_ID'),
    channelSecret: getenv('LINE_PAY_CHANNEL_SECRET'),
    merchantDeviceProfileId: 'POS-001',  // ID เครื่อง POS ของคุณ
    merchantDeviceType: 'POS',           // ประเภทอุปกรณ์
    env: 'sandbox'                        // หรือ 'production'
);

// สร้าง client
$client = new LinePayOfflineClient($config);

// ขอชำระเงินด้วยบาร์โค้ดของลูกค้า (oneTimeKey)
$response = $client->requestPayment([
    'amount' => 100,
    'currency' => 'THB',
    'oneTimeKey' => '12345678901245678', // จากบาร์โค้ด LINE Pay ของลูกค้า
    'orderId' => 'ORDER-' . time(),
    'packages' => [
        [
            'id' => 'PKG-001',
            'amount' => 100,
            'products' => [
                ['name' => 'กาแฟ', 'quantity' => 1, 'price' => 100]
            ]
        ]
    ]
]);

if ($response['returnCode'] === '0000') {
    echo "ชำระเงินสำเร็จ!\n";
    echo "Transaction ID: " . $response['info']['transactionId'] . "\n";
}
```

## API Methods

### ขอชำระเงิน

ขอชำระเงินด้วยบาร์โค้ดแบบใช้ครั้งเดียวของลูกค้า:

```php
$response = $client->requestPayment([
    'amount' => 100,
    'currency' => 'THB',
    'oneTimeKey' => '12345678901245678',
    'orderId' => 'ORDER-001',
    'options' => [
        'payment' => [
            'capture' => true  // Capture ทันที (ค่าเริ่มต้น)
        ],
        'extra' => [
            'branchId' => 'BRANCH-001',
            'branchName' => 'สาขาหลัก'
        ]
    ]
]);
```

### ตรวจสอบสถานะการชำระเงิน

ตรวจสอบสถานะการชำระเงิน (ใช้หลัง timeout):

```php
$status = $client->checkPaymentStatus('ORDER-001');
// คืนค่า: COMPLETE, FAIL, หรือ REFUND
echo "สถานะ: " . $status['info']['status'];
```

### Capture การชำระเงิน

Capture การชำระเงินที่ได้รับอนุมัติแล้ว:

```php
$response = $client->capturePayment(
    orderId: 'ORDER-001',
    amount: 100,
    currency: Currency::THB
);
```

### ยกเลิกการอนุมัติ

ยกเลิกการอนุมัติก่อน capture:

```php
$response = $client->voidAuthorization('ORDER-001');
```

### คืนเงิน

คืนเงินการชำระเงินที่เสร็จสมบูรณ์:

```php
// คืนเงินเต็มจำนวน
$response = $client->refundPayment('ORDER-001');

// คืนเงินบางส่วน
$response = $client->refundPayment('ORDER-001', 50);
```

### สอบถามการอนุมัติ

สอบถามข้อมูลการอนุมัติ:

```php
$auths = $client->queryAuthorizations(orderId: 'ORDER-001');
// หรือ
$auths = $client->queryAuthorizations(transactionId: '1234567890123456789');
```

### ดึงรายละเอียดการชำระเงิน

ดึงข้อมูลการชำระเงินโดยละเอียด:

```php
$details = $client->retrievePaymentDetails(orderId: 'ORDER-001');
```

## การจัดการข้อผิดพลาด

```php
use LinePay\Core\Errors\LinePayError;
use LinePay\Core\Errors\LinePayTimeoutError;
use LinePay\Core\Errors\LinePayConfigError;

try {
    $response = $client->requestPayment($request);
    
} catch (LinePayTimeoutError $e) {
    // เกิด timeout - ต้องตรวจสอบสถานะการชำระเงินเสมอ
    $status = $client->checkPaymentStatus($orderId);
    
    if ($status['info']['status'] === 'COMPLETE') {
        // การชำระเงินสำเร็จแม้จะ timeout
        handleSuccessfulPayment($status);
    } else {
        // การชำระเงินล้มเหลวหรือกำลังประมวลผล
        handleFailedPayment($status);
    }
    
} catch (LinePayError $e) {
    // API error
    echo "รหัสข้อผิดพลาด: " . $e->getReturnCode() . "\n";
    echo "ข้อความ: " . $e->getReturnMessage() . "\n";
    
} catch (LinePayConfigError $e) {
    // ข้อผิดพลาดการตั้งค่า
    echo "ข้อผิดพลาดการตั้งค่า: " . $e->getMessage() . "\n";
}
```

## ตัวเลือกการตั้งค่า

| ตัวเลือก | ประเภท | จำเป็น | คำอธิบาย |
|----------|--------|--------|----------|
| `channelId` | string | ✅ | LINE Pay Channel ID |
| `channelSecret` | string | ✅ | LINE Pay Channel Secret |
| `merchantDeviceProfileId` | string | ✅ | ID อุปกรณ์ POS/terminal ของคุณ |
| `merchantDeviceType` | string | ❌ | ประเภทอุปกรณ์ (ค่าเริ่มต้น: "POS") |
| `env` | string | ❌ | สภาพแวดล้อม: "sandbox" หรือ "production" |
| `timeout` | int | ❌ | timeout ของ request เป็นวินาที (ค่าเริ่มต้น: 20) |

## แนวปฏิบัติที่ดี

### 1. จัดการ Timeout อย่างถูกต้อง

LINE Pay Offline API อาจใช้เวลาถึง 40 วินาที ต้องตรวจสอบสถานะหลัง timeout เสมอ:

```php
try {
    $response = $client->requestPayment($request);
} catch (LinePayTimeoutError $e) {
    // อย่าสันนิษฐานว่าล้มเหลว - ตรวจสอบสถานะจริง
    $status = $client->checkPaymentStatus($orderId);
}
```

### 2. ตรวจสอบจำนวนเงินที่ชำระ

ต้องตรวจสอบจำนวนเงินใน response เสมอ:

```php
$response = $client->requestPayment($request);
$totalPaid = array_sum(array_column($response['info']['payInfo'], 'amount'));

if ($totalPaid !== $requestedAmount) {
    error_log("จำนวนเงินไม่ตรงกัน: ขอ $requestedAmount, จ่ายจริง $totalPaid");
}
```

### 3. ใช้ Environment Variables

อย่า hardcode ข้อมูลรับรอง:

```php
$config = new LinePayOfflineConfig(
    channelId: getenv('LINE_PAY_CHANNEL_ID'),
    channelSecret: getenv('LINE_PAY_CHANNEL_SECRET'),
    merchantDeviceProfileId: getenv('MERCHANT_DEVICE_ID')
);
```

## การทดสอบ

```bash
# รันการทดสอบ
composer test

# รันการวิเคราะห์แบบ static
composer analyze

# ตรวจสอบ code style
composer lint
```

## แพ็คเกจที่เกี่ยวข้อง

- [line-pay-core-v4](https://github.com/CarlLee1983/line-pay-core-v4-php) - Core SDK (dependency)
- [line-pay-online-v4](https://github.com/CarlLee1983/line-pay-online-v4-php) - Online Payment SDK

## สัญญาอนุญาต

MIT License - ดูรายละเอียดที่ [LICENSE](LICENSE)

## แหล่งข้อมูล

- [เอกสาร LINE Pay Offline API](https://pay.line.me/documents/offline.html)
- [LINE Pay Merchant Center](https://pay.line.me/portal/th/)
- [รายงานปัญหา](https://github.com/CarlLee1983/line-pay-offline-v4-php/issues)
