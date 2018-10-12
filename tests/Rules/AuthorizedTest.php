<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Rules\Authorized;
use Spatie\ValidationRules\Tests\TestClasses\Models\TestModel;
use Spatie\ValidationRules\Tests\TestClasses\Policies\TestModelPolicy;

class AuthorizedTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Gate::policy(TestModel::class, TestModelPolicy::class);
    }

    /** @test */
    public function it_will_return_true_if_the_gate_returns_true_for_the_given_ability_name()
    {
        $rule = new Authorized('edit', TestModel::class);

        $user = factory(User::class)->create(['id' => 1]);
        TestModel::create([
            'id' => 1,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $this->assertTrue($rule->passes('attribute', '1'));
    }

    /** @test */
    public function it_will_return_false_if_noone_is_logged_in()
    {
        $rule = new Authorized('edit', TestModel::class);

        $user = factory(User::class)->create(['id' => 1]);
        TestModel::create([
            'id' => 1,
            'user_id' => $user->id,
        ]);

        $this->assertFalse($rule->passes('attribute', '1'));
    }

    /** @test */
    public function it_will_return_false_if_the_model_is_not_found()
    {
        $rule = new Authorized('edit', TestModel::class);

        $user = factory(User::class)->create(['id' => 1]);
        TestModel::create([
            'id' => 1,
            'user_id' => $user->id,
        ]);

        $this->assertFalse($rule->passes('attribute', '2'));
    }

    /** @test */
    public function it_will_return_false_if_the_gate_returns_false()
    {
        $rule = new Authorized('edit', TestModel::class);

        $user = factory(User::class)->create(['id' => 1]);
        TestModel::create([
            'id' => 1,
            'user_id' => 2,
        ]);

        $this->assertFalse($rule->passes('attribute', '1'));
    }
}
