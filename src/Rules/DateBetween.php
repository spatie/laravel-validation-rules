<?php

namespace Spatie\ValidationRules\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateBetween implements Rule
{
    /** @var \Carbon\Carbon */
    protected $start;

    /** @var \Carbon\Carbon */
    protected $end;

    /** @var bool */
    protected $orEquals = true;

    public function __construct(Carbon $start, Carbon $end)
    {
        $this->start = $start->copy();

        $this->end = $end->copy();
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
        $date = Carbon::make($value);

        return $date->between($this->start, $this->end, $this->orEquals);
    }

    public function message(): string
    {
        return __('validationRules.date_between');
    }
}
