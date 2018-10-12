<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class DateGreaterThan implements Rule
{
    /** @var \Carbon\Carbon */
    protected $date;

    /** @var bool */
    protected $orEquals = false;

    public function __construct(Carbon $date)
    {
        $this->date = $date->copy();
    }

    public function orEquals(bool $orEquals = true): DateGreaterThan
    {
        $this->orEquals = $orEquals;

        return $this;
    }

    public function passes($attribute, $value)
    {
        $inputDate = Carbon::make($value);

        if ($this->orEquals) {
            return $inputDate->greaterThanOrEqualTo($this->date);
        }

        return $inputDate->greaterThan($this->date);
    }

    public function message()
    {
        if ($this->orEquals) {
            return __('validationRules.date_greater_than_or_equals');
        }

        return __('validationRules.date_greater_than');
    }
}
