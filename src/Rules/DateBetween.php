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
    protected $orEquals = false;

    public function __construct(Carbon $start, Carbon $end)
    {
        $this->start = $start->copy();

        $this->end = $end->copy();
    }

    public function orEquals(bool $orEquals = true): DateBetween
    {
        $this->orEquals = $orEquals;

        return $this;
    }

    public function withoutTime(): DateBetween
    {
        $this->start->startOfDay();

        $this->end->endOfDay();

        return $this;
    }

    public function passes($attribute, $value)
    {
        $date = Carbon::make($value);

        return $date->between($this->start, $this->end, $this->orEquals);
    }

    public function message()
    {
        return __('validationRules.date_between');
    }
}
