<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Spatie\ValidationRules\IsDateRule;

class PastDate implements Rule
{
    use IsDateRule;

    public function __construct(string $format = 'Y-m-d')
    {
        $this->format = $format;
    }

    public function passes($attribute, $value): bool
    {
        $date = $this->createDate($value);

        return $date->isPast();
    }

    public function message(): string
    {
        return __('validationRules.past_date');
    }
}
