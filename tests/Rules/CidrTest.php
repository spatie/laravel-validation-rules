<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Rules\Cidr;

final class CidrTest
{
    /** @test */
    public function it_will_return_true_for_a_cidr_address()
    {
        $rule = new Cidr;

        $this->assertTrue($rule->passes('attribute', '62.48.25.19/24'));
    }

    /** @test */
    public function it_will_return_false_for_an_address_without_a_trailing_netmask()
    {
        $rule = new Cidr;

        $this->assertFalse($rule->passes('attribute', '62.48.25.19'));
    }

    /** @test */
    public function it_will_return_false_for_a_non_address()
    {
        $rule = new Cidr;

        $this->assertFalse($rule->passes('attribute', 'fail'));
    }
}
