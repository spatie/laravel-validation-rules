<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Rules\Hash;
use Spatie\ValidationRules\Tests\TestCase;

final class HashTest extends TestCase
{
    /** @test */
    public function it_passes_with_a_correct_hash()
    {
        $rule = new Hash('$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'); // secret

        $this->assertTrue($rule->passes('attribute', 'secret'));
    }

    /** @test */
    public function it_fails_with_an_invalid_hash()
    {
        $rule = new Hash('$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'); // secret

        $this->assertFalse($rule->passes('attribute', 'fail'));
    }
}
