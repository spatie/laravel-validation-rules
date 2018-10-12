<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Rules\PastDate;
use Spatie\ValidationRules\Tests\TestCase;

class PastDateTest extends TestCase
{
    /** @test */
    public function it_will_return_true_when_is_past_date()
    {
        $rule = new PastDate();

        $this->assertTrue($rule->passes('attribute', now()->subDay()));
    }

    /** @test */
    public function it_will_return_false_when_not_past_date()
    {
        $rule = new PastDate();

        $this->assertFalse($rule->passes('attribute', now()->addDay()));
    }
}
