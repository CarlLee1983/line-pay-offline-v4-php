<?php

declare(strict_types=1);

namespace LinePay\Offline\Tests;

use LinePay\Offline\Enums\CheckPaymentStatus;
use LinePay\Offline\Enums\Currency;
use LinePay\Offline\Enums\PaymentMethod;
use LinePay\Offline\Enums\PaymentProvider;
use LinePay\Offline\Enums\PaymentStatus;
use PHPUnit\Framework\TestCase;

class EnumsTest extends TestCase
{
    public function testCurrencyValues(): void
    {
        $this->assertEquals('USD', Currency::USD->value);
        $this->assertEquals('TWD', Currency::TWD->value);
        $this->assertEquals('THB', Currency::THB->value);
        $this->assertEquals('JPY', Currency::JPY->value);
    }

    public function testPaymentMethodValues(): void
    {
        $this->assertEquals('CREDIT_CARD', PaymentMethod::CREDIT_CARD->value);
        $this->assertEquals('BALANCE', PaymentMethod::BALANCE->value);
        $this->assertEquals('POINT', PaymentMethod::POINT->value);
        $this->assertEquals('DISCOUNT', PaymentMethod::DISCOUNT->value);
    }

    public function testPaymentProviderValues(): void
    {
        $this->assertEquals('TSP', PaymentProvider::TSP->value);
        $this->assertEquals('PGW', PaymentProvider::PGW->value);
    }

    public function testPaymentStatusValues(): void
    {
        $this->assertEquals('AUTHORIZATION', PaymentStatus::AUTHORIZATION->value);
        $this->assertEquals('VOIDED_AUTHORIZATION', PaymentStatus::VOIDED_AUTHORIZATION->value);
        $this->assertEquals('EXPIRED_AUTHORIZATION', PaymentStatus::EXPIRED_AUTHORIZATION->value);
    }

    public function testCheckPaymentStatusValues(): void
    {
        $this->assertEquals('COMPLETE', CheckPaymentStatus::COMPLETE->value);
        $this->assertEquals('FAIL', CheckPaymentStatus::FAIL->value);
        $this->assertEquals('REFUND', CheckPaymentStatus::REFUND->value);
    }
}
