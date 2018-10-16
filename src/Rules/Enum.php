<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

class Enum implements Rule
{
    /** @var array */
    protected $validValues;

    public function __construct(string $enumClass)
    {
        $this->validValues = array_keys($enumClass::toArray());
    }

    public function passes($attribute, $value): bool
    {
        return in_array($value, $this->validValues);
    }

    public function message(): string
    {
        return __('validationRules.enum');
    }
}
