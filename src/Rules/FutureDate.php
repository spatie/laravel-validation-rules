<?php

namespace Spatie\ValidationRules\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class FutureDate implements Rule
{
    public function passes($attribute, $value): bool
    {
        $date = Carbon::make($value);

        return $date->isFuture();
    }

    public function message(): string
    {
        return __('validationRules.future_date');
    }
}
