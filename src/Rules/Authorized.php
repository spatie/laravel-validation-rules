<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Authorized implements Rule
{
    /** @var string */
    protected $ability;

    /** @var array */
    protected $arguments;

    /** @var string */
    protected $className;

    /** @var string */
    protected $attribute;

    /** @var string */
    protected $guard;

    public function __construct(string $ability, string $className, string $guard = null)
    {
        $this->ability = $ability;
        $this->className = $className;
        $this->guard = $guard;
    }

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if (! $user = Auth::guard($this->guard)->user()) {
            return false;
        }

        if (! $model = app($this->className)->resolveRouteBinding($value)) {
            return false;
        }

        return $user->can($this->ability, $model);
    }

    public function message(): string
    {
        $classBasename = class_basename($this->className);

        return __('validationRules::messages.authorized', [
            'attribute' => $this->attribute,
            'ability' => $this->ability,
            'className' => $classBasename,
        ]);
    }
}
