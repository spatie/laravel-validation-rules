<?php

namespace Spatie\ValidationRules\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\ValidationRules\ValidationRulesServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            function (string $modelName) {
                return 'Spatie\\ValidationRules\\Database\\Factories\\'.class_basename($modelName).'Factory';
            }
        );

        $this->setUpDatabase();
        $this->setUpGuard();
    }

    protected function getPackageProviders($app)
    {
        return [
            ValidationRulesServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('remember_token');
            $table->timestamps();
        });

        Schema::create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    protected function setUpGuard()
    {
        config([
            'auth.guards.alternate' => [
                'driver' => 'session',
                'provider' => 'users',
            ],
        ]);
    }
}
