<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

class Enum implements Rule
{
    /** @var array */
    protected $enumValues;

    public function __construct(string $enumClass)
    {
        $this->enumValues = $enumClass::toArray();
    }

    public function passes($attribute, $value)
    {
        return in_array($value, $this->enumValues);
    }

    public function message()
    {
        return 'This is not a valid value.';
    }
}
