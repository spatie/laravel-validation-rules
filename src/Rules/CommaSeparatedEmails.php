<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CommaSeparatedEmails implements Rule
{
    /** @var int|null */
    protected $minimum;

    /** @var int|null */
    protected $maximum;

    protected $message = '';

    public function passes($attribute, $value)
    {
        [$validEmails, $invalidEmails] = collect(explode(',', $value))
            ->map(function (string $rawEmail) {
                return trim($rawEmail);
            })
            ->partition(function (string $email) {
                return $this->isValidEmail($email);
            });

        if ($invalidEmails->count() === 1) {
            $this->message = __('validation.email', ['attribute' => $invalidEmails->first()]);

            return false;
        }

        if ($invalidEmails->count() > 1) {
            $this->message = __('validation.emails', ['attribute' => $invalidEmails->implode(',')]);

            return false;
        }

        if ($validEmails->unique()->count() !== $validEmails->count()) {
            $this->message = __('validation.unique_emails');

            return false;
        }

        if (! is_null($this->minimum)) {
            if ($validEmails->count() < $this->minimum) {
                $this->message = __('validation.minimum_emails', [
                    'actualCount' => $invalidEmails->implode(','),
                    'expectedMinimum' => $this->minimum,
                    'emailword' => Str::plural('e-mail address', $this->minimum),
                ]);

                return false;
            }
        }

        if (! is_null($this->maximum)) {
            if ($validEmails->count() > $this->maximum) {
                $this->message = __('validation.maximum_emails', [
                    'actualCount' => $invalidEmails->implode(','),
                    'expectedMaximum' => $this->maximum,
                    'emailword' => Str::plural('e-mail address', $this->maximum),
                ]);

                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return $this->message;
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

    protected function isValidEmail(string $email): bool
    {
        return Validator::make(['email' => $email], ['email' => 'email'])->passes();
    }
}
