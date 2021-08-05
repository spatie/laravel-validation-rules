<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Illuminate\Support\Facades\Validator;
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

    public function test_nullable_field()
    {
        $this->assertTrue(Validator::make(
            [
                'currency' => null,
            ],
            [
                'currency' => ['nullable', new Currency()],
            ]
        )->passes());

        $this->assertTrue(Validator::make(
            [
                'currency' => null,
            ],
            [
                'currency' => [new Currency()],
            ]
        )->fails());
    }

    public function test_empty_field()
    {
        $this->assertTrue(Validator::make(
            [
                'currency' => '',
            ],
            [
                'currency' => ['nullable', new Currency()],
            ]
        )->passes());

        $this->assertTrue(Validator::make(
            [
                'currency' => '',
            ],
            [
                'currency' => [new Currency()],
            ]
        )->passes());
    }

    public function test_required_field()
    {
        $this->assertTrue(Validator::make(
            [
                'currency' => null,
            ],
            [
                'currency' => ['required', new Currency()],
            ]
        )->fails());

        $this->assertTrue(Validator::make(
            [
                'currency' => '',
            ],
            [
                'currency' => ['required', new Currency()],
            ]
        )->fails());

        $this->assertTrue(Validator::make(
            [
                'currency' => 'USD',
            ],
            [
                'currency' => ['required', new Currency()],
            ]
        )->passes());
    }
}
