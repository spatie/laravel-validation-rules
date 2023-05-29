<?php

use Illuminate\Support\Facades\Lang;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;
use Spatie\ValidationRules\Rules\Enum;
use Spatie\ValidationRules\Tests\TestClasses\Enums\MyCLabsEnum;

test('myclabs it will return true for a value that is part of the enum', function () {
    $rule = new Enum(MyCLabsEnum::class);

    assertTrue($rule->passes('attribute', 'ONE'));

    assertFalse($rule->passes('attribute', 'FOUR'));
});

test('myclabs it passes attribute and valid values to the validation message', function () {
    Lang::addLines([
        'messages.enum' => ':attribute :validValues',
    ], Lang::getLocale(), 'validationRules');

    $rule = new Enum(MyCLabsEnum::class);

    $rule->passes('enum_field', 'abc');

    assertEquals('enum_field ONE, TWO, THREE', $rule->message());
});

test('spatie it will return true for a value that is part of the enum', function () {
    $rule = new Enum(MyCLabsEnum::class);

    assertTrue($rule->passes('attribute', 'ONE'));

    assertFalse($rule->passes('attribute', 'FOUR'));
});

test('spatie it passes attribute and valid values to the validation message', function () {
    Lang::addLines([
        'messages.enum' => ':attribute :validValues',
    ], Lang::getLocale(), 'validationRules');

    $rule = new Enum(MyCLabsEnum::class);

    $rule->passes('enum_field', 'abc');

    assertEquals('enum_field ONE, TWO, THREE', $rule->message());
});
