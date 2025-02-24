<?php

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;
use Spatie\ValidationRules\Rules\Delimited;
use Spatie\ValidationRules\Rules\Enum;
use Spatie\ValidationRules\Tests\TestClasses\Enums\MyCLabsEnum;

beforeEach(fn () => $this->rule = (new Delimited('email')));

it('can use custom errors messages', function () {
    $rule = (new Delimited('email', [
        'email.min' => 'You must specify at least :min emails',
    ]))->min(2);

    $rule->passes('email', 'sebastian@example.com');
    $this->assertEquals('You must specify at least 2 emails', $rule->message());
});

it('can validate comma separated email addresses', function () {
    assertRulePasses('sebastian@example.com, alex@example.com');
    assertRulePasses('');
    assertRulePasses('sebastian@example.com');
    assertRulePasses('sebastian@example.com, alex@example.com, brent@example.com');
    assertRulePasses(' sebastian@example.com   , alex@example.com  ,   brent@example.com  ');

    assertRuleFails('invalid@');
    assertRuleFails('nocomma@example.com nocommatoo@example.com');

    assertRuleFails('valid@example.com, invalid@');
});

it('can validate a minimum of valid addresses', function () {
    $this->rule->min(1);
    assertRuleFails('');
    assertRuleFails('  ');
    assertRulePasses('sebastian@example.com');

    $this->rule->min(2);
    assertRuleFails('');
    assertRuleFails('sebastian@example.com');
    assertRulePasses('sebastian@example.com, alex@example.com');
    assertRulePasses('sebastian@example.com, alex@example.com, brent@example.com');
});

it('can validate a maximum amount of emailaddress', function () {
    $this->rule->max(2);
    assertRulePasses('');
    assertRulePasses('sebastian@example.com');
    assertRulePasses('sebastian@example.com, alex@example.com');
    assertRuleFails('sebastian@example.com, alex@example.com, brent@example.com');
});

it('will fail if not all email addresses are unique', function () {
    assertRuleFails('sebastian@example.com, sebastian@example.com');
});

it('can allow duplicates', function () {
    $this->rule->allowDuplicates();

    assertRulePasses('sebastian@example.com, sebastian@example.com');
}
);

it('can use a custom separator', function () {
    $this->rule->separatedBy(';');

    assertRulePasses('sebastian@example.com; freek@example.com');
    assertRuleFails('sebastian@example.com, freek@example.com');
});

it('can skip trimming items', function () {
    $this->rule->doNotTrimItems();

    assertRulePasses('sebastian@example.com,freek@example.com');
    assertRuleFails('sebastian@example.com, freek@example.com');
    assertRuleFails('sebastian@example.com , freek@example.com');
});

it('can treat input as csv', function () {
    $rule = (new Delimited('string|min:5'))->asCsv();

    $this->assertTrue($rule->passes('attribute', '"Doe, John", "Doe, Jane"'));
    $this->assertFalse($rule->passes('attribute', '"Doe", "Jane"'));
});

it('can accept a rule as an array', function () {
    $rule = new Delimited(['email']);

    $this->assertTrue($rule->passes('attribute', 'sebastian@example.com, alex@example.com, brent@example.com'));
    $this->assertFalse($rule->passes('attribute', 'blablabla'));
});

it('can use composite rules', function () {
    $rule = new Delimited('email|max:20');

    $this->assertTrue($rule->passes('attribute', 'short@example.com'));
    $this->assertFalse($rule->passes('attribute', 'short'));
    $this->assertFalse($rule->passes('attribute', 'loooooooonnnggg@example.com'));
});

it('can accept chained properties', function () {
    $this->rule->doNotTrimItems()->max(2);

    assertRulePasses('sebastian@example.com,freek@example.com');
    assertRuleFails('sebastian@example.com , freek@example.com');
    assertRuleFails('sebastian@example.com,freek@example.com,alex@example.com');
});

it('can accept another rule', function () {
    $rule = new Delimited(new Enum(MyCLabsEnum::class));

    $this->assertTrue($rule->passes('attribute', 'ONE, TWO'));
    $this->assertFalse($rule->passes('attribute', 'ONE, FOUR'));
});

it('can handle numeric values properly', function () {
    $rule = new Delimited('numeric');
    $this->assertTrue($rule->min(2)->passes('attribute', '0, 1'));
});

it('can validate nested attributes properly', function () {
    $rule = new Delimited('email');
    $this->assertFalse($rule->passes('a.0.b', 'invalid email'));
});

it('can handle custom error messages', function () {
    $rule = new Delimited('email', ['emails.email' => 'a custom message comes here.']);
    $this->assertFalse($rule->passes('emails', 'invalid-email-address'));
    $this->assertSame($rule->message(), 'a custom message comes here.');
});

it('can only validate string values', function() {
    $rule = new Delimited('string');

    $this->assertFalse($rule->passes('attribute', ['foo']));
    $this->assertFalse($rule->passes('attribute', (object) ['foo' => 'bar']));
    $this->assertFalse($rule->passes('attribute', 555));
    $this->assertFalse($rule->passes('attribute', [123]));
    $this->assertFalse($rule->passes('attribute', null));

    $this->assertTrue($rule->passes('attribute', "555"));
    $this->assertTrue($rule->passes('attribute', "[foo]"));
    $this->assertTrue($rule->passes('attribute', "null"));
});

function assertRulePasses(string $value): void
{
    assertTrue(rulePasses($value));
}

function assertRuleFails(string $value): void
{
    assertFalse(rulePasses($value));
}

function rulePasses(string $value): bool
{
    return test()->rule->passes('attribute', $value);
}
