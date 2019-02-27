<?php

namespace Spatie\ValidationRules\Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\ValidationRules\ValidationRulesServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();

        $this->app->make(EloquentFactory::class)->load(__DIR__.'/factories');
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
}
