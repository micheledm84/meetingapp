<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

date_default_timezone_set('Europe/Rome');


class CheckTime implements Rule
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
        if (request('start') == null || request('end') == null) {
            return true;
        }

        if (request('start') > request('end')) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The end of the meeting must be after the beginning';
    }
}
