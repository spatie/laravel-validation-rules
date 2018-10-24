<?php

namespace Spatie\ValidationRules\Rules;

use Carbon\Carbon;
use Spatie\ValidationRules\Exceptions\InvalidDate;
use Spatie\ValidationRules\IsDateRule;
use Illuminate\Contracts\Validation\Rule;

class DateBetween implements Rule
{
    use IsDateRule;

    /** @var \Carbon\Carbon */
    protected $start;

    /** @var \Carbon\Carbon */
    protected $end;

    /** @var bool */
    protected $orEquals = true;

    /** @var string|null */
    protected $message = null;

    public function __construct(Carbon $start, Carbon $end, string $format = 'Y-m-d')
    {
        $this->start = $start->copy();

        $this->end = $end->copy();

        $this->format = $format;
    }

    public function includeBoundaries(): DateBetween
    {
        $this->orEquals = true;

        return $this;
    }

    public function excludeBoundaries(): DateBetween
    {
        $this->orEquals = false;

        return $this;
    }

    public function withoutTime(): DateBetween
    {
        $this->start->startOfDay();

        $this->end->endOfDay();

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        try {
            $date = $this->createDate($value);

            return $date->between($this->start, $this->end, $this->orEquals);
        } catch (InvalidDate $exception) {
            $this->message = $exception->getMessage();

            return false;
        }
    }

    public function message(): string
    {
        return $this->message ?? __('validationRules.date_between');
    }
}
