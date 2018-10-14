<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash as HashFacade;

final class Hash implements Rule
{
    private $hash;

    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $plaintext
     * @return bool
     */
    public function passes($attribute, $plaintext)
    {
        return HashFacade::check($plaintext, $this->hash);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validationRules.hash');
    }
}
