<?php

namespace Spatie\ValidationRules\Tests\TestClasses\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use Spatie\ValidationRules\Tests\TestClasses\Models\TestModel;

class TestModelPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, TestModel $testModel): bool
    {
        return $testModel->user->id === $user->id;
    }
}
