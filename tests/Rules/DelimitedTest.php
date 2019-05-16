<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Rules\Delimited;
use Spatie\ValidationRules\Rules\CountryCode;
use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\CommaSeparatedEmails;

class DelimitedTest extends TestCase
{
    /** @var \Spatie\ValidationRules\Rules\Delimited */
    private $rule;

    public function setUp(): void
    {
        parent::setUp();

        $this->rule = (new Delimited('email'));
    }

    /** @test */
    public function it_can_validate_comma_separated_email_addresses()
    {
        $this->assertRulePasses('sebastian@spatie.be, alex@spatie.be');
        $this->assertRulePasses('');
        $this->assertRulePasses('sebastian@spatie.be');
        $this->assertRulePasses('sebastian@spatie.be, alex@spatie.be, brent@spatie.be');
        $this->assertRulePasses(' sebastian@spatie.be   , alex@spatie.be  ,   brent@spatie.be  ');


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

    /** @test */
    public function it_can_allow_duplicates()
    {
        $this->rule->allowDuplicates();

        $this->assertRulePasses('sebastian@spatie.be, sebastian@spatie.be');
    }

    /** @test */
    public function it_can_use_a_custom_separator()
    {
        $this->rule->separatedBy(';');

        $this->assertRulePasses('sebastian@spatie.be; freek@spatie.be');
        $this->assertRuleFails('sebastian@spatie.be, freek@spatie.be');
    }

    /** @test */
    public function it_can_skip_trimming_items()
    {
        $this->rule->doNotTrimItems();

        $this->assertRulePasses('sebastian@spatie.be,freek@spatie.be');
        $this->assertRuleFails('sebastian@spatie.be, freek@spatie.be');
        $this->assertRuleFails('sebastian@spatie.be , freek@spatie.be');

    }

    /** @test */
    public function it_can_accept_a_rule_as_an_array()
    {
        $rule = new Delimited(['email']);

        $this->assertTrue($rule->passes('attribute', 'sebastian@spatie.be, alex@spatie.be, brent@spatie.be'));
        $this->assertFalse($rule->passes('attribute', 'blablabla'));
    }

    /** @test */
    public function it_can_accept_another_rule()
    {
        $rule = new Delimited(new CountryCode());

        $this->assertTrue($rule->passes('attribute', 'BE, NL'));
        $this->assertFalse($rule->passes('attribute', 'BE, NL, blablabla'));
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
