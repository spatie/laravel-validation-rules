<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Rules\Currency;
use Spatie\ValidationRules\Tests\TestCase;

class CurrencyTest extends TestCase
{
    public function test_valid_currency_passes()
    {
        $this->assertTrue((new Currency())->passes('currency', 'USD'));
    }

    public function test_invalid_currency_fails()
    {
        $this->assertFalse((new Currency())->passes('currency', 'XYZ'));
    }

    public function test_null_currency_fails()
    {
        $this->assertFalse((new Currency())->passes('currency', null));
    }

    public function test_empty_currency_fails()
    {
        $this->assertFalse((new Currency())->passes('currency', ''));
    }
}
