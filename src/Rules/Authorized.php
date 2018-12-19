<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class Authorized implements Rule
{
    /** @var string */
    protected $ability;

    /** @var array */
    protected $arguments;

    public function __construct(string $ability, string $className)
    {
        $this->ability = $ability;

        $this->className = $className;
    }

    public function passes($attribute, $value): bool
    {
        if (! $user = Auth::user()) {
            return false;
        }

        if (! $model = $this->className::find($value)) {
            return false;
        }

        return $user->can($this->ability, $model);
    }

    public function message(): string
    {
        return __('validation.authorized');
    }
}
