<?php

use Spatie\ValidationRules\Tests\TestClasses\Models\TestModel;

$factory->define(TestModel::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
    ];
});
