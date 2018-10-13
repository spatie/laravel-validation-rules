<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

final class Slug implements Rule
{
    public function passes($attribute, $value)
    {
        return $value === str_slug($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validationRules.slug');
    }
}
