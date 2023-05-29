<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;
use Spatie\ValidationRules\Rules\Authorized;
use Spatie\ValidationRules\Tests\TestClasses\Models\TestModel;
use Spatie\ValidationRules\Tests\TestClasses\Models\TestRouteKeyModel;
use Spatie\ValidationRules\Tests\TestClasses\Policies\TestModelPolicy;
use Spatie\ValidationRules\Tests\TestClasses\Policies\TestRouteKeyModelPolicy;
use Spatie\ValidationRules\Tests\TestModel\User;

beforeEach(function () {
    Gate::policy(TestModel::class, TestModelPolicy::class);
    Gate::policy(TestRouteKeyModel::class, TestRouteKeyModelPolicy::class);
});

it('will return true if the gate returns true for the given ability name', function () {
    $rule = new Authorized('edit', TestModel::class);

    $user = User::factory()->create(['id' => 1]);
    TestModel::create([
        'id' => 1,
        'user_id' => $user->id,
    ]);

    $this->actingAs($user);

    assertTrue($rule->passes('attribute', '1'));
});

it('will return false if none is logged in', function () {
    $rule = new Authorized('edit', TestModel::class);

    $user = User::factory()->create(['id' => 1]);
    TestModel::create([
        'id' => 1,
        'user_id' => $user->id,
    ]);

    assertFalse($rule->passes('attribute', '1'));
});

it('will return false if the model is not found', function () {
    $rule = new Authorized('edit', TestModel::class);

    $user = User::factory()->create(['id' => 1]);
    TestModel::create([
        'id' => 1,
        'user_id' => $user->id,
    ]);

    assertFalse($rule->passes('attribute', '2'));
});

it('will return false if the gate returns false', function () {
    $rule = new Authorized('edit', TestModel::class);

    User::factory()->create(['id' => 1]);
    TestModel::create([
        'id' => 1,
        'user_id' => 2,
    ]);

    assertFalse($rule->passes('attribute', '1'));
});

it('passes attribute ability and class name to the validation message', function () {
    Lang::addLines([
        'messages.authorized' => ':attribute :ability and :className',
    ], Lang::getLocale(), 'validationRules');

    $rule = new Authorized('edit', TestModel::class);

    $rule->passes('name_field', 'John Doe');

    assertEquals('name_field edit and TestModel', $rule->message());
});

it('will pass when using alternate route key name', function () {
    $rule = new Authorized('edit', TestRouteKeyModel::class);

    $user = User::factory()->create(['id' => 1]);
    TestRouteKeyModel::create([
        'id' => 1,
        'name' => 'abc123',
        'user_id' => 1,
    ]);

    $this->actingAs($user);

    assertTrue($rule->passes('attribute', 'abc123'));
});

it('will pass when using alternate column name', function () {
    $rule = new Authorized('edit', TestRouteKeyModel::class, column: 'id');

    $user = User::factory()->create(['id' => 1]);
    TestRouteKeyModel::create([
        'id' => 1,
        'name' => 'abc123',
        'user_id' => 1,
    ]);

    $this->actingAs($user);

    assertTrue($rule->passes('attribute', '1'));
});

it('will pass if alternate auth guard is specified', function () {
    $rule = new Authorized('edit', TestModel::class, 'alternate');

    $user = User::factory()->create(['id' => 1]);
    TestModel::create([
        'id' => 1,
        'user_id' => 1,
    ]);

    $this->actingAs($user, 'alternate');

    assertTrue($rule->passes('attribute', '1'));
});

it('will return false if auth guard is incorrect', function () {
    $rule = new Authorized('edit', TestModel::class, 'web');

    $user = User::factory()->create(['id' => 1]);
    TestModel::create([
        'id' => 1,
        'user_id' => 1,
    ]);

    $this->actingAs($user, 'alternate');

    assertFalse($rule->passes('attribute', '1'));
});
