<?php

/*|=============================================================================|
  | helpers.php
  | Ian Kollipara <ian.kollipara@cune.edu>
  |-----------------------------------------------------------------------------|
  | This file contains helper functions that can be used throughout the
  |=============================================================================| */

if (! function_exists('enum_values')) {
    /**
     * Get the values of an enum
     *
     * @param  class-string  $enum
     * @return array
     */
    function enum_values($enum)
    {
        return array_column($enum::cases(), 'value');
    }
}
