# 參與貢獻 LINE Pay Offline V4 PHP SDK

感謝您考慮為此專案做出貢獻！🎉

[English Version](CONTRIBUTING.md)

## 行為準則

參與此專案，您同意維護一個尊重和包容的環境。

## 如何貢獻

### 回報錯誤

1. 在 [Issues](https://github.com/CarlLee1983/line-pay-offline-v4-php/issues) 中檢查是否已有相同的錯誤回報
2. 如果沒有，使用 Bug Report 模板建立新的 Issue
3. 請包含：
   - 清楚的描述
   - 重現步驟
   - 預期行為 vs 實際行為
   - PHP 版本和環境

### 建議功能

1. 查看現有的 [Issues](https://github.com/CarlLee1983/line-pay-offline-v4-php/issues) 和 [Discussions](https://github.com/CarlLee1983/line-pay-offline-v4-php/discussions)
2. 使用 Feature Request 模板建立 Issue，包含：
   - 問題描述
   - 建議的解決方案
   - 使用案例

### Pull Request

1. Fork 此專案
2. 建立功能分支：`git checkout -b feature/your-feature-name`
3. 進行修改
4. 執行測試和檢查：
   ```bash
   composer test
   composer analyze
   composer lint
   ```
5. 使用描述性的訊息提交
6. Push 並建立 Pull Request

## 開發環境設定

### 需求

- PHP 8.1 或更高版本
- Composer

### 安裝

```bash
# Clone 您的 fork
git clone https://github.com/YOUR_USERNAME/line-pay-offline-v4-php.git
cd line-pay-offline-v4-php

# 安裝依賴
composer install
```

### 執行測試

```bash
# 執行所有測試
composer test

# 執行靜態分析
composer analyze

# 檢查程式碼風格
composer lint

# 修正程式碼風格
composer lint:fix
```

## 程式碼規範

### PHP 風格

- 遵循 PSR-12 程式碼規範
- 使用 PHP 8.1+ 特性（enums、readonly、named arguments）
- 為所有參數和回傳值添加類型宣告
- 撰寫完整的 PHPDoc 註解

### 範例

```php
<?php

declare(strict_types=1);

namespace LinePay\Offline;

/**
 * 展示程式碼規範的範例類別。
 */
class Example
{
    /**
     * 建立新的實例。
     *
     * @param string $name  名稱參數
     * @param int    $value 數值參數
     */
    public function __construct(
        public readonly string $name,
        public readonly int $value
    ) {
    }

    /**
     * 處理資料。
     *
     * @return array<string, mixed> 處理結果
     */
    public function process(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
```

### Commit 訊息

遵循 Conventional Commits：

- `feat:` 新功能
- `fix:` 錯誤修正
- `docs:` 僅文件更新
- `style:` 程式碼風格變更
- `refactor:` 程式碼重構
- `test:` 新增測試
- `chore:` 維護任務

範例：`feat: add support for batch refunds`

### 測試

- 為所有新功能撰寫測試
- 維持或提高程式碼覆蓋率
- 使用描述性的測試方法名稱

```php
public function testRequestPaymentWithValidOneTimeKey(): void
{
    // Arrange（安排）
    $oneTimeKey = '12345678901234567';
    
    // Act（執行）
    // ...
    
    // Assert（斷言）
    $this->assertEquals('0000', $response['returnCode']);
}
```

## 專案結構

```
line-pay-offline-v4-php/
├── src/
│   ├── Config/              # 設定類別
│   ├── Enums/               # PHP 8.1 枚舉
│   └── LinePayOfflineClient.php # 主要客戶端
├── tests/                   # PHPUnit 測試
├── .github/                 # GitHub 配置
└── composer.json
```

## 有問題？

- 開啟 [Discussion](https://github.com/CarlLee1983/line-pay-offline-v4-php/discussions)
- 查看現有 issues 和文件

感謝您的貢獻！🙏
