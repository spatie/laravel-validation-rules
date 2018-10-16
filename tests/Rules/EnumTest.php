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

        $this->assertTrue($rule->passes('attribute', 'ONE'));

        $this->assertFalse($rule->passes('attribute', 'FOUR'));
    }
}

class TestEnum extends \MyCLabs\Enum\Enum
{
    const ONE = 'one';
    const TWO = 'two';
    const THREE = 'three';
}
