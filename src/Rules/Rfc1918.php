<?php

namespace Spatie\ValidationRules\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class Rfc1918.
 *
 * Validates that the value is an IP address and does not overlap with one of the RFC1918 non-routable ranges.
 */
final class Rfc1918 implements Rule
{
    const RFC1918_RANGES = [
        '10.0.0.0/8',
        '172.16.0.0/21',
        '192.168.0.0/16',
    ];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $parts = explode('/', $value);

        if (! filter_var($parts[0], FILTER_VALIDATE_IP)) {
            return false;
        }

        $ip = inet_pton($parts[0]);

        $range = $this->calculateRange($ip, count($parts) > 1 ? $parts[1] : 32);

        foreach (static::RFC1918_RANGES as $rfc1918Range) {
            list($privateIp, $privateMask) = explode('/', $rfc1918Range);
            $privateRange = $this->calculateRange(inet_pton($privateIp), $privateMask);

            if ($range[1] >= $privateRange[0] && $range[0] <= $privateRange[1]) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $address Packed representation of the address used to define the range.
     * @param int $mask
     * @return string[] Packed representations of the starting and ending addresses in this range.
     */
    private function calculateRange(string $address, int $mask): array
    {
        // Index of returned array starts at 1, because `unpack` is weird.
        $words = unpack('n*', $address);

        $start = [];
        $end = [];

        for ($i = 0; $i < count($words); $i++) {
            $shift = min(max($mask - 16 * $i, 0), 16);
            $wordMask = ~(0xffff >> $shift) & 0xffff;

            $start[$i] = $words[$i + 1] & $wordMask;
            $end[$i] = $words[$i + 1] | ~$wordMask;
        }

        return [
            pack('n*', ...$start),
            pack('n*', ...$end),
        ];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validationRules.rfc1918');
    }
}
