<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FQDNResolves implements Rule
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
        return checkdnsrr($value, 'A') || checkdnsrr($value, 'AAAA') || checkdnsrr($value, 'CNAME');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Domain does not resolve. (Only A, AAAA, CNAME)';
    }
}
