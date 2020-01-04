<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

date_default_timezone_set('Europe/Rome');


class CheckDateTime implements Rule
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
        if (request('date_meeting') < date("Y-m-d")) {
            return false;
        } 

        if (request('date_meeting') == date("Y-m-d")) {
            if (request('start') < date("H:i:s") || request('end') < date("H:i:s")) {
                return false;
            }
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
        
        return "The meeting must be set from now on";
    }
}
