<?php

namespace Spatie\ValidationRules;

use Carbon\Carbon;
use InvalidArgumentException;
use Spatie\ValidationRules\Exceptions\InvalidDate;

trait IsDateRule
{
    /** @var string */
    protected $format;

    protected function createDate(string $value): Carbon
    {
        try {
            return Carbon::createFromFormat($this->format, $value);
        } catch (InvalidArgumentException $exception) {
            throw InvalidDate::withFormat($this->format, $value);
        }
    }
}
