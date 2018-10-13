<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\NewPassword;
use Illuminate\Contracts\Auth\Authenticatable;

class NewPasswordTest extends TestCase
{
    /** @test */
    public function it_will_return_true_if_new_password_used()
    {
        $rule = new NewPassword($this->mock_user());

        $this->assertTrue($rule->passes('attribute', 'new_secret'));
    }

    private function mock_user(): Authenticatable
    {
        $mock = $this->getMockForAbstractClass(Authenticatable::class);

        $mock->expects($this->once())
            ->method('getAuthPassword')
            ->willReturn('$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'); // secret

        return $mock;
    }

    /** @test */
    public function it_will_return_false_if_old_password_used()
    {
        $rule = new NewPassword($this->mock_user());

        $this->assertFalse($rule->passes('attribute', 'secret'));
    }

    /** @test */
    public function it_will_return_true_if_no_user_is_used()
    {
        $rule = new NewPassword;

        $this->assertTrue($rule->passes('attribute', 'secret'));
    }
}
