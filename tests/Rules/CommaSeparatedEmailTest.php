<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\CommaSeparatedEmails;

class CommaSeparatedEmailTest extends TestCase
{
    /** @var \Spatie\ValidationRules\Rules\CommaSeparatedEmails */
    private $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->rule = (new CommaSeparatedEmails());
    }

    /** @test */
    public function it_can_validate_comma_separated_email_addresses()
    {
        $this->assertRulePasses('');
        $this->assertRulePasses('sebastian@spatie.be');
        $this->assertRulePasses('sebastian@spatie.be, alex@spatie.be');
        $this->assertRulePasses('sebastian@spatie.be, alex@spatie.be, brent@spatie.be');

        $this->assertRuleFails('invalid@');
        $this->assertRuleFails('nocomma@spatie.be nocommatoo@spatie.be');

        $this->assertRuleFails('valid@spatie.be, invalid@');
    }

    /** @test */
    public function it_can_validate_a_minimum_of_valid_addresses()
    {
        $this->rule->min(2);
        $this->assertRuleFails('');
        $this->assertRuleFails('sebastian@spatie.be');
        $this->assertRulePasses('sebastian@spatie.be, alex@spatie.be');
        $this->assertRulePasses('sebastian@spatie.be, alex@spatie.be, brent@spatie.be');
    }

    /** @test */
    public function it_can_validate_a_maximum_amount_of_emailaddress()
    {
        $this->rule->max(2);
        $this->assertRulePasses('');
        $this->assertRulePasses('sebastian@spatie.be');
        $this->assertRulePasses('sebastian@spatie.be, alex@spatie.be');
        $this->assertRuleFails('sebastian@spatie.be, alex@spatie.be, brent@spatie.be');
    }

    /** @test */
    public function it_will_fail_if_not_all_email_addresses_are_unique()
    {
        $this->assertRuleFails('sebastian@spatie.be, sebastian@spatie.be');
    }

    protected function assertRulePasses(string $value)
    {
        $this->assertTrue($this->rulePasses($value));
    }

    protected function assertRuleFails(string $value)
    {
        $this->assertFalse($this->rulePasses($value));
    }

    public function rulePasses(string $value): bool
    {
        return $this->rule->passes('attribute', $value);
    }
}
