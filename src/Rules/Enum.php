<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

class Enum implements Rule
{
    /** @var array */
    protected $validValues;

    /** @var string */
    protected $attribute;

    public function __construct(string $enumClass)
    {
        $this->validValues = array_keys($enumClass::toArray());
    }

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        return in_array($value, $this->validValues);
    }

    public function message(): string
    {
        $validValues = implode(', ', $this->validValues);

        return __('validationRules::messages.enum', [
            'attribute' => $this->attribute,
            'validValues' => $validValues,
        ]);
    }
}
