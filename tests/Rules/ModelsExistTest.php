<?php

namespace Spatie\ValidationRules\Tests\Rules;

use Spatie\ValidationRules\Tests\TestModel\User;
use Illuminate\Support\Facades\Lang;
use Spatie\ValidationRules\Rules\ModelsExist;
use Spatie\ValidationRules\Tests\TestCase;

class ModelsExistTest extends TestCase
{
    /** @test */
    public function it_will_return_true_if_all_model_ids_exist()
    {
        $rule = new ModelsExist(User::class);

        $this->assertTrue($rule->passes('userIds', []));

        $this->assertFalse($rule->passes('userIds', [1]));
        User::factory()->create(['id' => 1]);
        $this->assertTrue($rule->passes('userIds', [1]));

        $this->assertFalse($rule->passes('userIds', [1, 2]));
        User::factory()->create(['id' => 2]);
        $this->assertTrue($rule->passes('userIds', [1, 2]));
        $this->assertTrue($rule->passes('userIds', [1]));
    }

    /** @test */
    public function it_can_validate_existence_of_models_by_column()
    {
        $rule = new ModelsExist(User::class, 'email');

        $this->assertTrue($rule->passes('userEmails', []));

        $this->assertFalse($rule->passes('userEmails', ['user@example.com']));
        User::factory()->create(['email' => 'user@example.com']);
        $this->assertTrue($rule->passes('userEmails', ['user@example.com']));
    }

    /** @test */
    public function it_passes_relevant_data_to_the_validation_message()
    {
        Lang::addLines([
            'messages.model_ids' => ':attribute :model :modelAttribute :modelIds',
        ], Lang::getLocale(), 'validationRules');

        $rule = new ModelsExist(User::class, 'id');

        $rule->passes('userIds', [1, 2]);

        $this->assertEquals('userIds User id 1, 2', $rule->message());
    }
}
