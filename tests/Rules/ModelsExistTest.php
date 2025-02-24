<?php

use Illuminate\Support\Facades\Lang;
use Spatie\ValidationRules\Rules\ModelsExist;
use Spatie\ValidationRules\Tests\TestModel\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

it('will return true if all model ids exist', function () {
    $rule = new ModelsExist(User::class);

    assertTrue($rule->passes('userIds', []));

    assertFalse($rule->passes('userIds', [1]));
    User::factory()->create(['id' => 1]);
    assertTrue($rule->passes('userIds', [1]));

    assertFalse($rule->passes('userIds', [1, 2]));
    User::factory()->create(['id' => 2]);
    assertTrue($rule->passes('userIds', [1, 2]));
    assertTrue($rule->passes('userIds', [1]));
});

it('can validate existence of models by column', function () {
    $rule = new ModelsExist(User::class, 'email');

    assertTrue($rule->passes('userEmails', []));

    assertFalse($rule->passes('userEmails', ['user@example.com']));
    User::factory()->create(['email' => 'user@example.com']);
    assertTrue($rule->passes('userEmails', ['user@example.com']));
});

it('passes relevant data to the validation message', function () {
    Lang::addLines([
        'messages.model_ids' => ':attribute :model :modelAttribute :modelIds',
    ], Lang::getLocale(), 'validationRules');

    $rule = new ModelsExist(User::class, 'id');

    $rule->passes('userIds', [1, 2]);

    assertEquals('userIds User id 1, 2', $rule->message());
});
