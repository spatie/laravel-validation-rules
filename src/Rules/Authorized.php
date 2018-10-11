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

    public function __construct(string $ability, $arguments = [])
    {
        $this->ability = $ability;

        if (! is_array($arguments)) {
            $arguments = [$arguments];
        }

        $this->arguments = $arguments;
    }

    public function passes($attribute, $value)
    {
        return optional(Auth::user())->can($this->ability, $this->arguments) ?? false;
    }

    public function message()
    {
        return __('validationRules.authorized');
    }
}
