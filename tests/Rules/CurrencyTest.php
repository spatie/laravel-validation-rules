<?php

use Illuminate\Support\Facades\Validator;
use Spatie\ValidationRules\Rules\Currency;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

test('valid currency passes', function () {
    assertTrue((new Currency)->passes('currency', 'USD'));
});

test('invalid currency fails', function () {
    assertFalse((new Currency)->passes('currency', 'XYZ'));
});

test('null currency fails', function () {
    assertFalse((new Currency)->passes('currency', null));
});

test('empty currency fails', function () {
    assertFalse((new Currency)->passes('currency', ''));
});

test('nullable field', function () {
    assertTrue(Validator::make(
        [
            'currency' => null,
        ],
        [
            'currency' => ['nullable', new Currency],
        ]
    )->passes());

    assertTrue(Validator::make(
        [
            'currency' => null,
        ],
        [
            'currency' => [new Currency],
        ]
    )->fails());
});

test('empty field', function () {
    assertTrue(Validator::make(
        [
            'currency' => '',
        ],
        [
            'currency' => ['nullable', new Currency],
        ]
    )->passes());

    assertTrue(Validator::make(
        [
            'currency' => '',
        ],
        [
            'currency' => [new Currency],
        ]
    )->passes());
});

test('required field', function () {
    assertTrue(Validator::make(
        [
            'currency' => null,
        ],
        [
            'currency' => ['required', new Currency],
        ]
    )->fails());

    assertTrue(Validator::make(
        [
            'currency' => '',
        ],
        [
            'currency' => ['required', new Currency],
        ]
    )->fails());

    assertTrue(Validator::make(
        [
            'currency' => 'USD',
        ],
        [
            'currency' => ['required', new Currency],
        ]
    )->passes());
});
