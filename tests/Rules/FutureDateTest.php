<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\FutureDate;

class FutureDateTest extends TestCase
{
    /** @test */
    public function it_will_return_true_when_is_future_date()
    {
        $rule = new FutureDate();

        $this->assertTrue($rule->passes('attribute', now()->addDay()));
    }

    /** @test */
    public function it_will_return_false_when_not_future_date()
    {
        $rule = new FutureDate();

        $this->assertFalse($rule->passes('attribute', now()->subDay()));
    }
}
