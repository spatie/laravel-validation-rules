<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

final class Cidr implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match(
            '/^(([01]?\d?\d|2[0-4]\d|25[0-5])\.){3}([01]?\d?\d|2[0-4]\d|25[0-5])\/(\d{1}|[0-2]{1}\d{1}|3[0-2])$/',
            $value
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validationRules.cidr');
    }
}
