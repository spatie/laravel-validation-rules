<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use League\ISO3166\ISO3166;

class CountryCode implements Rule
{
    /** @var bool */
    protected $required;

    /** @var string */
    protected $attribute;

    public function __construct(bool $required = true)
    {
        $this->required = $required;
    }

    public function nullable(): self
    {
        $this->required = false;

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if (! $this->required && ($value === '0' || $value === 0 || $value === null)) {
            return true;
        }

        $countries = Arr::pluck((new ISO3166())->all(), ISO3166::KEY_ALPHA2);

        return in_array($value, $countries, true);
    }

    public function message(): string
    {
        return __('validationRules::messages.country_code', [
            'attribute' => $this->attribute,
        ]);
    }
}
