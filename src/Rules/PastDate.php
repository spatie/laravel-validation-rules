<?php

namespace Spatie\ValidationRules\Rules;

use Spatie\ValidationRules\Exceptions\InvalidDate;
use Spatie\ValidationRules\IsDateRule;
use Illuminate\Contracts\Validation\Rule;

class PastDate implements Rule
{
    use IsDateRule;

    /** @var string|null */
    protected $message;

    public function __construct(string $format = 'Y-m-d')
    {
        $this->format = $format;
    }

    public function passes($attribute, $value): bool
    {
        try {
            $date = $this->createDate($value);

            return $date->isPast();
        } catch (InvalidDate $exception) {
            $this->message = $exception->getMessage();

            return false;
        }
    }

    public function message(): string
    {
        return $this->message ?? __('validationRules.past_date');
    }
}
