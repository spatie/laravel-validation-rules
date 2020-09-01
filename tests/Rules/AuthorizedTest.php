<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Spatie\ValidationRules\Rules\Authorized;
use Spatie\ValidationRules\Tests\TestCase;
use Spatie\ValidationRules\Tests\TestClasses\Models\TestModel;
use Spatie\ValidationRules\Tests\TestClasses\Models\TestRouteKeyModel;
use Spatie\ValidationRules\Tests\TestClasses\Policies\TestModelPolicy;
use Spatie\ValidationRules\Tests\TestClasses\Policies\TestRouteKeyModelPolicy;

class AuthorizedTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Gate::policy(TestModel::class, TestModelPolicy::class);
        Gate::policy(TestRouteKeyModel::class, TestRouteKeyModelPolicy::class);
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

    /** @test */
    public function it_passes_attribute_ability_and_class_name_to_the_validation_message()
    {
        Lang::addLines([
            'messages.authorized' => ':attribute :ability and :className',
        ], Lang::getLocale(), 'validationRules');

        $rule = new Authorized('edit', TestModel::class);

        $rule->passes('name_field', 'John Doe');

        $this->assertEquals('name_field edit and TestModel', $rule->message());
    }

    /** @test */
    public function it_will_pass_when_using_alternate_route_key_name()
    {
        $rule = new Authorized('edit', TestRouteKeyModel::class);

        $user = factory(User::class)->create(['id' => 1]);
        TestRouteKeyModel::create([
            'id' => 1,
            'name' => 'abc123',
            'user_id' => 1,
        ]);

        $this->actingAs($user);

        $this->assertTrue($rule->passes('attribute', 'abc123'));
    }

    /** @test */
    public function it_will_pass_if_alternate_auth_guard_is_specified()
    {
        $rule = new Authorized('edit', TestModel::class, 'alternate');

        $user = factory(User::class)->create(['id' => 1]);
        TestModel::create([
            'id' => 1,
            'user_id' => 1,
        ]);

        $this->actingAs($user, 'alternate');

        $this->assertTrue($rule->passes('attribute', '1'));
    }

    /** @test */
    public function it_will_return_false_if_auth_guard_is_incorrect()
    {
        $rule = new Authorized('edit', TestModel::class, 'web');

        $user = factory(User::class)->create(['id' => 1]);
        TestModel::create([
            'id' => 1,
            'user_id' => 1,
        ]);

        $this->actingAs($user, 'alternate');

        $this->assertFalse($rule->passes('attribute', '1'));
    }
}
