<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Illuminate\Support\Facades\Lang;
use Spatie\ValidationRules\Rules\Enum;
use Spatie\ValidationRules\Tests\TestCase;

class EnumTest extends TestCase
{
    /** @test */
    public function myclabs_it_will_return_true_for_a_value_that_is_part_of_the_enum()
    {
        $rule = new Enum(MyCLabsEnum::class);

        $this->assertTrue($rule->passes('attribute', 'ONE'));

        $this->assertFalse($rule->passes('attribute', 'FOUR'));
    }

    /** @test */
    public function myclabs_it_passes_attribute_and_valid_values_to_the_validation_message()
    {
        Lang::addLines([
            'messages.enum' => ':attribute :validValues',
        ], Lang::getLocale(), 'validationRules');

        $rule = new Enum(MyCLabsEnum::class);

        $rule->passes('enum_field', 'abc');

        $this->assertEquals('enum_field ONE, TWO, THREE', $rule->message());
    }

    /** @test */
    public function spatie_it_will_return_true_for_a_value_that_is_part_of_the_enum()
    {
        $rule = new Enum(MyCLabsEnum::class);

        $this->assertTrue($rule->passes('attribute', 'ONE'));

        $this->assertFalse($rule->passes('attribute', 'FOUR'));
    }

    /** @test */
    public function spatie_it_passes_attribute_and_valid_values_to_the_validation_message()
    {
        Lang::addLines([
            'messages.enum' => ':attribute :validValues',
        ], Lang::getLocale(), 'validationRules');

        $rule = new Enum(MyCLabsEnum::class);

        $rule->passes('enum_field', 'abc');

        $this->assertEquals('enum_field ONE, TWO, THREE', $rule->message());
    }
}

class MyCLabsEnum extends \MyCLabs\Enum\Enum
{
    const ONE = 'one';
    const TWO = 'two';
    const THREE = 'three';
}

/**
 * @method static self ONE()
 * @method static self TWO()
 * @method static self THREE()
 */
class SpatieEnum extends \Spatie\Enum\Enum
{
}
