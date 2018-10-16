<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Carbon\Carbon;
use Spatie\ValidationRules\Exceptions\InvalidDate;
use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\DateBetween;

class DateBetweenTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::make('2018-01-01 00:00:00'));
    }

    /** @test */
    public function it_will_return_true_when_between_or_equals()
    {
        $rule = new DateBetween(now(), now()->addDays(2));

        $this->assertTrue($rule->passes('attribute', '2018-01-01'));
        $this->assertTrue($rule->passes('attribute', '2018-01-02'));
        $this->assertTrue($rule->passes('attribute', '2018-01-03'));
    }

    /** @test */
    public function it_will_return_false_when_not_between()
    {
        $rule = new DateBetween(now(), now()->addDays(2));

        $this->assertFalse($rule->passes('attribute', '2017-01-01'));
        $this->assertFalse($rule->passes('attribute', '2019-01-01'));
    }

    /** @test */
    public function it_will_return_false_when_on_boundary_and_boundaries_are_excluded()
    {
        $rule = (new DateBetween(now(), now()->addDays(2)))
            ->excludeBoundaries();

        $this->assertFalse($rule->passes('attribute', '2018-01-01'));
        $this->assertTrue($rule->passes('attribute', '2018-01-02'));
        $this->assertFalse($rule->passes('attribute', '2018-01-03'));
    }

    /** @test */
    public function it_will_return_true_when_comparing_without_time_and_within_day_boundary()
    {
        $rule = (new DateBetween(
            Carbon::make('2018-01-01 12:00:00'),
            Carbon::make('2018-01-03 12:00:00'),
            'Y-m-d H:i:s'
        ))
            ->withoutTime();

        $this->assertTrue($rule->passes('attribute', Carbon::make('2018-01-01 10:00:00')));
        $this->assertTrue($rule->passes('attribute', Carbon::make('2018-01-03 14:00:00')));
    }

    /** @test */
    public function it_will_return_false_when_comparing_with_time_and_within_day_boundary()
    {
        $rule = (new DateBetween(
            Carbon::make('2018-01-01 12:00:00'),
            Carbon::make('2018-01-03 12:00:00'),
            'Y-m-d H:i:s'
        ));

        $this->assertFalse($rule->passes('attribute', Carbon::make('2018-01-01 10:00:00')));
        $this->assertFalse($rule->passes('attribute', Carbon::make('2018-01-03 14:00:00')));
    }

    /** @test */
    public function it_throws_an_invalid_date_exception_on_invalid_format()
    {
        $rule = (new DateBetween(
            Carbon::make('2018-01-01 12:00:00'),
            Carbon::make('2018-01-03 12:00:00'),
            'Y-m-d'
        ));

        $this->expectException(InvalidDate::class);

        $rule->passes('attribute', Carbon::make('2018-01-01'));
    }
}
