<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Carbon\Carbon;
use Spatie\ValidationRules\Rules\DateLessThan;
use Spatie\ValidationRules\Tests\TestCase;

class DateLessThanTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::create(2018, 01, 01, 00, 00, 00));
    }

    /** @test */
    public function it_returns_true_when_less()
    {
        $rule = new DateLessThan(now());

        $this->assertTrue($rule->passes('attribute', now()->subDay()));
    }

    /** @test */
    public function it_returns_false_when_not_less()
    {
        $rule = new DateLessThan(now());

        $this->assertFalse($rule->passes('attribute', now()->addDays(1)));
        $this->assertFalse($rule->passes('attribute', now()));
    }

    /** @test */
    public function it_returns_true_when_equal_with_equals_option()
    {
        $rule = (new DateLessThan(now()))
            ->orEquals();

        $this->assertTrue($rule->passes('attribute', now()));
    }
}
