<?php

/*|=============================================================================|
  | helpers.php
  | Ian Kollipara <ian.kollipara@cune.edu>
  |-----------------------------------------------------------------------------|
  | This file contains helper functions that can be used throughout the
  |=============================================================================| */

if (! function_exists('in_range')) {
    /**
     * Check if the given number is within the given range.
     *
     * @param  int  $check  The number to check.
     * @param  int  $min  The minimum value of the range.
     * @param  int  $max  The maximum value of the range.
     * @param  bool  $inclusive  Whether the range is inclusive.
     */
    function in_range(int $check, int $min, int $max, bool $inclusive = true): bool
    {
        return $inclusive
            ? $check >= $min && $check <= $max
            : $check > $min && $check < $max;
    }
}

if (! function_exists('explode_if_string')) {
    /**
     * Explode a string into an array if it is not already an array.
     *
     * @param  string|array  $value  The value to explode.
     * @param  string  $delimiter  The delimiter to explode the string by.
     */
    function explode_if_string($value, string $delimiter = ' '): array
    {
        return is_array($value) ? $value : explode($delimiter, $value);
    }
}

if (! function_exists('enum_to_select')) {
    /**
     * Convert an enum to a select array.
     *
     * @param  class-string  $enum  The enum to convert.
     */
    function enum_to_select($enum): array
    {
        return collect($enum::cases())->map(fn ($case) => [$case->value => $case->label])->collapseWithKeys()->toArray();
    }
}
