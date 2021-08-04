<?php

namespace Spatie\ValidationRules\Rules;

use Alcohol\ISO4217;
use DomainException;
use Illuminate\Contracts\Validation\Rule;
use OutOfBoundsException;

class Currency implements Rule
{
    /** @var string */
    protected $attribute;

    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if ($value === null) {
            return false;
        }

        try {
            return boolval((new ISO4217())->getByAlpha3($value)); // This method does not accept null
        } catch (DomainException | OutOfBoundsException $exception) {
            return false;
        }
    }

    public function message(): string
    {
        return __('validationRules::messages.currency', [
            'attribute' => $this->attribute,
        ]);
    }
}
