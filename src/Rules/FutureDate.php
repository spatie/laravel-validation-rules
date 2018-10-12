<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\Validation\Rule;

class FutureDate implements Rule
{
    public function passes($attribute, $value)
    {
        $date = Carbon::make($value);

        return $date->isFuture();
    }

    public function message()
    {
        return __('validationRules.future_date');
    }
}
