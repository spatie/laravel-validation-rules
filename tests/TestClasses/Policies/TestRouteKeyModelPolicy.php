<?php

namespace Spatie\ValidationRules\Tests\TestClasses\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User;
use Spatie\ValidationRules\Tests\TestClasses\Models\TestRouteKeyModel;

class TestRouteKeyModelPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, TestRouteKeyModel $testModel): bool
    {
        return $testModel->user->id === $user->id;
    }
}
