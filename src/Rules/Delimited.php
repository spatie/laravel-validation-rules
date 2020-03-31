<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class Delimited implements Rule
{
    /** @var string|array|\Illuminate\Contracts\Validation\Rule */
    protected $rule;

    protected $minimum = null;

    protected $maximum = null;

    protected $allowDuplicates = false;

    protected $message = '';

    protected $separatedBy = ',';

    /** @var bool */
    protected $trimItems = true;

    /** @var string */
    protected $validationMessageWord = 'item';

    public function __construct($rule)
    {
        $this->rule = $rule;
    }

    public function min(int $minimum)
    {
        $this->minimum = $minimum;

        return $this;
    }

    public function max(int $maximum)
    {
        $this->maximum = $maximum;

        return $this;
    }

    public function allowDuplicates(bool $allowed = true)
    {
        $this->allowDuplicates = $allowed;

        return $this;
    }

    public function separatedBy(string $separator)
    {
        $this->separatedBy = $separator;

        return $this;
    }

    public function doNotTrimItems()
    {
        $this->trimItems = false;

        return true;
    }

    public function validationMessageWord(string $word)
    {
        $this->validationMessageWord = $word;

        return $this;
    }

    public function passes($attribute, $value)
    {
        if ($this->trimItems) {
            $value = trim($value);
        }

        $items = collect(explode($this->separatedBy, $value))
            ->filter(function ($item) {
                return strlen((string) $item) > 0;
            });

        if (! is_null($this->minimum)) {
            if ($items->count() < $this->minimum) {
                $this->message = __('validationRules::messages.delimited.min', [
                    'minimum' => $this->minimum,
                    'actual' => $items->count(),
                    'item' => Str::plural($this->validationMessageWord, $items->count()),
                ]);

                return false;
            }
        }

        if (! is_null($this->maximum)) {
            if ($items->count() > $this->maximum) {
                $this->message = __('validationRules::messages.delimited.max', [
                    'maximum' => $this->maximum,
                    'actual' => $items->count(),
                    'item' => Str::plural($this->validationMessageWord, $items->count()),
                ]);

                return false;
            }
        }

        if ($this->trimItems) {
            $items = $items->map(function (string $item) {
                return trim($item);
            });
        }

        foreach ($items as $item) {
            [$isValid, $validationMessage] = $this->validate($attribute, $item);

            if (! $isValid) {
                $this->message = $validationMessage;

                return false;
            }
        }

        if (! $this->allowDuplicates) {
            if ($items->unique()->count() !== $items->count()) {
                $this->message = __('validationRules::messages.delimited.unique');

                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }

    protected function validate(string $attribute, string $item): array
    {
        $attribute = Str::afterLast($attribute, '.');

        $validator = Validator::make([$attribute => $item], [$attribute => $this->rule]);

        return [
            $validator->passes(),
            $validator->getMessageBag()->first($attribute),
        ];
    }
}
