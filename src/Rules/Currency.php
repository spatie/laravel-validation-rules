<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use League\ISO3166\ISO3166;

class Currency implements Rule
{
    /** @var string */
    protected $attribute;

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if ($value === null || $value === '') {
            return false;
        }

        $currencies = array_unique(data_get((new ISO3166())->all(), '*.currency.*'));

        return in_array($value, $currencies, true);
    }

    public function message(): string
    {
        return __('validationRules::messages.currency', [
            'attribute' => $this->attribute,
        ]);
    }
}
