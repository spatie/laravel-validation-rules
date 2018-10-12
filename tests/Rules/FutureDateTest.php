<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Carbon\Carbon;
use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\FutureDate;

class FutureDateTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::make('2018-01-01 00:00:00'));
    }

    /** @test */
    public function it_will_return_true_when_is_future_date()
    {
        $rule = new FutureDate();

        $this->assertTrue($rule->passes('attribute', '2018-01-02'));
    }

    /** @test */
    public function it_will_return_false_when_not_future_date()
    {
        $rule = new FutureDate();

        $this->assertFalse($rule->passes('attribute', '2017-01-01'));
    }
}
