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

    public function __construct(string $ability, $arguments = [])
    {
        $this->ability = $ability;

        $this->arguments = array_wrap($arguments);
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
