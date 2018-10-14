<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Auth\Authenticatable;

final class NewPassword implements Rule
{
    private $user;

    public function __construct(Authenticatable $user = null)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! $this->user) {
            return true;
        }

        return ! Hash::check($value, $this->user->getAuthPassword());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validationRules.new_password');
    }
}
