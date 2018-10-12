<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Illuminate\Support\Carbon;
use Spatie\ValidationRules\Rules\DateBetween;
use Spatie\ValidationRules\Tests\TestCase;

class DateBetweenTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::create(2018, 01, 01, 00, 00, 00));
    }

    /** @test */
    public function it_will_return_true_when_between()
    {
        $rule = new DateBetween(now(), now()->addDays(2));

        $this->assertTrue($rule->passes('attribute', now()->addDays(1)));
    }

    /** @test */
    public function it_will_return_false_when_not_between()
    {
        $rule = new DateBetween(now(), now()->addDays(2));

        $this->assertFalse($rule->passes('attribute', now()->subDays(1)));
        $this->assertFalse($rule->passes('attribute', now()->addDays(3)));
    }

    /** @test */
    public function it_will_return_false_when_on_boundary()
    {
        $rule = new DateBetween(now(), now()->addDays(2));

        $this->assertFalse($rule->passes('attribute', now()));
        $this->assertFalse($rule->passes('attribute', now()->addDays(2)));
    }

    /** @test */
    public function it_will_return_true_when_on_boundary_with_equals_option()
    {
        $rule = (new DateBetween(now(), now()->addDays(2)))
            ->orEquals();

        $this->assertTrue($rule->passes('attribute', now()));
        $this->assertTrue($rule->passes('attribute', now()->addDays(2)));
    }

    /** @test */
    public function it_will_return_true_when_comparing_without_time_and_within_day_boundary()
    {
        $rule = (new DateBetween(
            Carbon::createFromTime(12, 00, 00),
            Carbon::createFromTime(12, 00, 00)->addDays(2)
        ))
            ->orEquals()
            ->withoutTime();

        $this->assertTrue($rule->passes('attribute', Carbon::createFromTime(10, 00, 00)));
        $this->assertTrue($rule->passes('attribute', Carbon::createFromTime(14, 00, 00)->addDays(2)));
    }

    /** @test */
    public function it_will_return_false_when_comparing_with_time_and_within_day_boundary()
    {
        $rule = (new DateBetween(
            Carbon::createFromTime(12, 00, 00),
            Carbon::createFromTime(12, 00, 00)->addDays(2)
        ))->orEquals();

        $this->assertFalse($rule->passes('attribute', Carbon::createFromTime(10, 00, 00)));
        $this->assertFalse($rule->passes('attribute', Carbon::createFromTime(14, 00, 00)->addDays(2)));
    }
}
