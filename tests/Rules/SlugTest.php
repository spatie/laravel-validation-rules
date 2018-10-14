<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Rules\Slug;
use Spatie\ValidationRules\Tests\TestCase;

final class SlugTest extends TestCase
{
    /** @test */
    public function it_will_return_true_for_a_slug_value()
    {
        $rule = new Slug;

        $this->assertTrue($rule->passes('attribute', 'sluggy-freelance'));
    }

    /** @test */
    public function it_will_return_false_for_a_misformatted_value()
    {
        $rule = new Slug;

        $this->assertFalse($rule->passes('attribute', 'Test Fail'));
    }
}
