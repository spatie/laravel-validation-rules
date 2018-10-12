<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class DateLessThan implements Rule
{
    /** @var \Carbon\Carbon */
    protected $date;

    /** @var bool */
    protected $orEquals = true;

    public function __construct(Carbon $date)
    {
        $this->date = $date->copy();
    }

    public function includeBoundaries(): DateLessThan
    {
        $this->orEquals = true;

        return $this;
    }

    public function excludeBoundaries(): DateLessThan
    {
        $this->orEquals = false;

        return $this;
    }

    public function passes($attribute, $value)
    {
        $inputDate = Carbon::make($value);

        if ($this->orEquals) {
            return $inputDate->lessThanOrEqualTo($this->date);
        }

        return $inputDate->lessThan($this->date);
    }

    public function message()
    {
        if ($this->orEquals) {
            return __('validationRules.date_less_than_or_equals');
        }

        return __('validationRules.date_less_than');
    }
}
