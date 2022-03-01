<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cidr implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $m = true;
        if (strpos($value, ":") !== false) {
            // ipv6
            if (strpos($value, "/") !== false) {
                list($value, $mask) = explode("/", $value);
                $m = filter_var(
                    $mask,
                    \FILTER_VALIDATE_INT,
                    ["options" => ["min_range" => 0, "max_range" => 128]]
                );
            }
            return $m && filter_var($value, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6);
        } else {
            // ipv4
            if (strpos($value, "/") !== false) {
                list($value, $mask) = explode("/", $value);
                $m = filter_var(
                    $mask,
                    \FILTER_VALIDATE_INT,
                    ["options" => ["min_range" => 0, "max_range" => 32]]
                );
            }
            return $m && filter_var($value, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute must be a valid IP address or CIDR range.";
    }
}
