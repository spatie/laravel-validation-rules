<?php

namespace Spatie\ValidationRules\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\ValidationRules\Tests\TestModel\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        static $password;

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password ?: $password = bcrypt('secret'),
            'remember_token' => Str::random(10),
        ];
    }
}
