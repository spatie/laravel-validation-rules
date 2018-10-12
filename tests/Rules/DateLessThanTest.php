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

        Carbon::setTestNow(Carbon::make('2018-01-01'));
    }

    /** @test */
    public function it_returns_true_when_less_or_equal()
    {
        $rule = new DateLessThan(now());

        $this->assertTrue($rule->passes('attribute', '2018-01-01'));
        $this->assertTrue($rule->passes('attribute', '2017-01-02'));
    }

    /** @test */
    public function it_returns_false_when_not_less()
    {
        $rule = new DateLessThan(now());

        $this->assertFalse($rule->passes('attribute', '2018-01-02'));
    }

    /** @test */
    public function it_returns_false_with_boundaries_excluded()
    {
        $rule = (new DateLessThan(now()))
            ->excludeBoundaries();

        $this->assertFalse($rule->passes('attribute', '2018-01-01'));
    }
}
