<?php

namespace Spatie\ValidationRules\Tests\Rules;

use ReflectionClass;
use Spatie\ValidationRules\Rules\Enum;
use Spatie\ValidationRules\Tests\TestCase;

class EnumTest extends TestCase
{
    /** @test */
    public function it_will_return_true_for_a_value_that_is_part_of_the_enum()
    {
        $rule = new Enum(TestEnum::class);

        $this->assertTrue($rule->passes('attribute', TestEnum::ONE));

        $this->assertFalse($rule->passes('attribute', 'four'));
    }
}

class TestEnum
{
    const ONE = 'one';
    const TWO = 'two';
    const THREE = 'three';

    public static function toArray()
    {
        $reflection = new ReflectionClass(TestEnum::class);

        return $reflection->getConstants();
    }
}
