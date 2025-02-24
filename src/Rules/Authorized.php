<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class Authorized implements Rule
{
    protected string $attribute;

    public function __construct(
        protected string $ability,
        protected string $className,
        protected ?string $guard = null,
        protected ?string $column = null,
    ) {}

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if (! $user = Auth::guard($this->guard)->user()) {
            return false;
        }

        if (! $model = app($this->className)->resolveRouteBinding($value, $this->column)) {
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
