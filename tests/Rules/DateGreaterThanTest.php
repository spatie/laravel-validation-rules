<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Carbon\Carbon;
use Spatie\ValidationRules\Rules\DateGreaterThan;
use Spatie\ValidationRules\Tests\TestCase;

class DateGreaterThanTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::create(2018, 01, 01, 00, 00, 00));
    }

    /** @test */
    public function it_returns_true_when_greater()
    {
        $rule = new DateGreaterThan(now());

        $this->assertTrue($rule->passes('attribute', now()->addDay()));
    }

    /** @test */
    public function it_returns_false_when_not_greater()
    {
        $rule = new DateGreaterThan(now());

        $this->assertFalse($rule->passes('attribute', now()->subDays(1)));
        $this->assertFalse($rule->passes('attribute', now()));
    }

    /** @test */
    public function it_returns_true_when_equal_with_equals_option()
    {
        $rule = (new DateGreaterThan(now()))
            ->orEquals();

        $this->assertTrue($rule->passes('attribute', now()));
    }
}
