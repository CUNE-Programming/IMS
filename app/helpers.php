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
