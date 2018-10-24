<?php

namespace Spatie\ValidationRules\Rules;

use Spatie\ValidationRules\Exceptions\InvalidDate;
use Spatie\ValidationRules\IsDateRule;
use Illuminate\Contracts\Validation\Rule;

class FutureDate implements Rule
{
    use IsDateRule;

    /** @var string|null */
    protected $message = null;

    public function __construct(string $format = 'Y-m-d')
    {
        $this->format = $format;
    }

    public function passes($attribute, $value): bool
    {
        try {
            $date = $this->createDate($value);

            return $date->isFuture();
        } catch (InvalidDate $exception) {
            $this->message = $exception->getMessage();

            return false;
        }
    }

    public function message(): string
    {
        return $this->message ?? __('validationRules.future_date');
    }
}
