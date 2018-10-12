<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\Rule;

class PastDate implements Rule
{
    public function passes($attribute, $value)
    {
        $date = Carbon::make($value);

        return $date->isPast();
    }

    public function message()
    {
        return __('validationRules.past_date');
    }
}
