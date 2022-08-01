<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

    /** @var array */
    protected $customErrorMessages;

    public function __construct($rule, array $customErrorMessages = [])
    {
        $this->rule = $rule;
        $this->customErrorMessages = $customErrorMessages;
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

        return $this;
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
                $this->message = $this->getErrorMessage($attribute, 'min', [
                    'min' => $this->minimum,
                    'actual' => $items->count(),
                    'item' => Str::plural($this->validationMessageWord, $items->count()),
                ]);

                return false;
            }
        }

        if (! is_null($this->maximum)) {
            if ($items->count() > $this->maximum) {
                $this->message = $this->getErrorMessage($attribute, 'max', [
                    'max' => $this->maximum,
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
                $this->message = $this->getErrorMessage($attribute, 'unique');

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
        $attribute = Arr::last(explode('.', $attribute));

        $validator = Validator::make(
            [$attribute => $item],
            [$attribute => $this->rule],
            $this->customErrorMessages
        );

        return [
            $validator->passes(),
            $validator->getMessageBag()->first($attribute),
        ];
    }

    protected function getErrorMessage($attribute, $rule, $data = [])
    {
        if (array_key_exists($attribute . '.' . $rule, $this->customErrorMessages)) {
            return __($this->customErrorMessages[$attribute . '.' . $rule], $data);
        }

        return __('validationRules::messages.delimited.' . $rule, $data);
    }
}
