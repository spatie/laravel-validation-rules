<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Illuminate\Support\Facades\Lang;
use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\CountryCode;

class CountryCodeTest extends TestCase
{
    /** @test */
    public function it_will_return_true_for_a_valid_iso_3166_country_code()
    {
        $rule = new CountryCode();

        $this->assertTrue($rule->passes('attribute', 'BE'));

        $this->assertFalse($rule->passes('attribute', null));

        $this->assertFalse($rule->passes('attribute', 0));

        $this->assertFalse($rule->passes('attribute', '0'));

        $this->assertFalse($rule->passes('attribute', 'LMAO'));
    }

    /** @test */
    public function it_can_be_a_nullable_country_code_field()
    {
        $rule = (new CountryCode())->nullable();

        $this->assertTrue($rule->passes('attribute', 'BE'));

        $this->assertTrue($rule->passes('attribute', null));

        $this->assertTrue($rule->passes('attribute', 0));

        $this->assertFalse($rule->passes('attribute', false));

        $this->assertFalse($rule->passes('attribute', 'LMAO'));
    }

    /** @test */
    public function it_passes_the_attribute_name_to_the_validation_message()
    {
        Lang::addLines([
            'validation.country_code' => ':attribute',
        ], Lang::getLocale());

        $rule = new CountryCode();

        $rule->passes('enum_field', 'WRONG');

        $this->assertEquals('enum_field', $rule->message());
    }
}
