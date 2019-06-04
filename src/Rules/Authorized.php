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

    /** @var string */
    protected $className;

    /** @var string */
    protected $attribute;

    public function __construct(string $ability, string $className)
    {
        $this->ability = $ability;

        $this->className = $className;
    }

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

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
        $classBasename = class_basename($this->className);

        return __('validationRules::messages.authorized', [
            'attribute' => $this->attribute,
            'ability' => $this->ability,
            'className' => $classBasename,
        ]);
    }
}
