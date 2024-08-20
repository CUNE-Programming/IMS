<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CuneEmail implements ValidationRule
{
    /**
     * Validate if the given email is a valid CUNE email address.
     * We only want CUNE students to register for the platform.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! str($value)->endsWith(['@cune.org', '@cune.edu', '@student.cune.edu'])) {
            $fail(__('The :attribute must be a CUNE email address.'));
        }
    }
}
