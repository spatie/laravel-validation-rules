<?php

namespace Spatie\ValidationRules\Tests\Rules;

use App\Models\Enums\UserRole;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\ValidationRules\Rules\Authorized;
use Spatie\ValidationRules\Tests\TestCase;

class AuthorizedTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->actingAs(factory(User::class)->create());
    }

    /** @test */
    public function it_will_return_true_if_the_gate_returns_true_for_the_given_ability_name()
    {
        Gate::define('abilityName', function () {
            return true;
        });

        $rule = new Authorized('abilityName');

        $this->assertTrue($rule->passes('attribute', 'value'));
    }

    /** @test */
    public function it_will_return_false_if_the_gate_returns_true_for_the_given_ability_name()
    {
        Gate::define('otherAbilityName', function () {
            return false;
        });

        $rule = new Authorized('otherAbilityName');

        $this->assertFalse($rule->passes('attribute', 'value'));
    }

    /** @test */
    public function it_will_return_false_if_there_is_noone_logged_in()
    {
        Auth::logout();

        Gate::define('noUserAbilityName', function () {
            return true;
        });

        $rule = new Authorized('noUserAbilityName');

        $this->assertFalse($rule->passes('attribute', 'value'));
    }

    /** @test */
    public function it_can_accept_an_argument()
    {
        Gate::define('argumentAbilityName', function (User $user, $argument) {
            return $argument === true;
        });

        $rule = new Authorized('argumentAbilityName', true);
        $this->assertTrue($rule->passes('attribute', 'value'));

        $rule = new Authorized('argumentAbilityName', false);
        $this->assertFalse($rule->passes('attribute', 'value'));
    }

    /** @test */
    public function it_can_accept_multiple_arguments_as_an_array()
    {
        Gate::define('arrayAbilityName', function (User $user, int $argumentA, int $argumentB) {
            return $argumentA + $argumentB === 3;
        });

        $rule = new Authorized('arrayAbilityName', [1,2]);
        $this->assertTrue($rule->passes('attribute', 'value'));

        $rule = new Authorized('arrayAbilityName', [2,3]);
        $this->assertFalse($rule->passes('attribute', 'value'));
    }
}
