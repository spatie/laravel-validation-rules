<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Rules\Rfc1918;
use Spatie\ValidationRules\Tests\TestCase;

class Rfc1918Test extends TestCase
{
    /** @test */
    public function it_will_return_true_for_a_public_address_without_a_mask()
    {
        $rule = new Rfc1918;

        $this->assertTrue($rule->passes('attribute', '52.25.12.78'));
    }

    /** @test */
    public function it_will_return_true_for_a_public_address_with_a_mask()
    {
        $rule = new Rfc1918;

        $this->assertTrue($rule->passes('attribute', '52.25.12.78/24'));
    }

    /** @test */
    public function it_will_return_false_for_a_private_address()
    {
        $rule = new Rfc1918;

        $this->assertFalse($rule->passes('attribute', '192.168.0.1'));
    }

    /** @test */
    public function it_will_return_false_for_a_non_address()
    {
        $rule = new Rfc1918;

        $this->assertFalse($rule->passes('attribute', 'fail'));
    }
}
