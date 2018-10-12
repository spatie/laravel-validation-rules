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

        Carbon::setTestNow(Carbon::make('2018-01-01'));
    }

    /** @test */
    public function it_returns_true_when_greater_or_equal()
    {
        $rule = new DateGreaterThan(now());

        $this->assertTrue($rule->passes('attribute', '2018-01-01'));
        $this->assertTrue($rule->passes('attribute', '2018-01-02'));
    }

    /** @test */
    public function it_returns_false_when_not_greater()
    {
        $rule = new DateGreaterThan(now());

        $this->assertFalse($rule->passes('attribute', '2017-01-01'));
    }

    /** @test */
    public function it_returns_false_with_boundaries_excluded()
    {
        $rule = (new DateGreaterThan(now()))
            ->excludeBoundaries();

        $this->assertFalse($rule->passes('attribute', '2018-01-01'));
    }
}
