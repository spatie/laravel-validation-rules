<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Carbon\Carbon;
use Spatie\ValidationRules\Rules\PastDate;
use Spatie\ValidationRules\Tests\TestCase;

class PastDateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::make('2018-01-01 00:00:00'));
    }

    /** @test */
    public function it_will_return_true_when_is_past_date()
    {
        $rule = new PastDate();

        $this->assertTrue($rule->passes('attribute', '2017-01-01'));
    }

    /** @test */
    public function it_will_return_false_when_not_past_date()
    {
        $rule = new PastDate();

        $this->assertFalse($rule->passes('attribute', '2018-01-02'));
    }

    /** @test */
    public function an_invalid_date_returns_false()
    {
        $rule = (new PastDate('Y-m-d'));

        $this->assertFalse($rule->passes('attribute', Carbon::make('2017-01-01 10:00:00')));
    }
}
