<?php

namespace Spatie\ValidationRules\Exceptions;

use Exception;

class InvalidDate extends Exception
{
    public static function withFormat(string $format, string $value): InvalidDate
    {
        return new self(__("Invalid date {$value} for format {$format}"));
    }
}
