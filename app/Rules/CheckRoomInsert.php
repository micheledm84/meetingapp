<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class CheckRoomInsert implements Rule
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

        $meetings = DB::table('meetings')
        ->where('id_room', request('room'))
        ->where('date', request('date_meeting'))
        ->where(function ($query) {
            $query->where(function($sub_q) {
                    $sub_q->where('start_hour', '>=', request('start'))
                            ->where('start_hour', '<', request('end'));
                })
                ->orWhere(function($sub_q) {
                    $sub_q->where('start_hour', '<', request('start'))
                            ->where('end_hour', '>=', request('end'));
                })
                ->orWhere(function($sub_q) {
                    $sub_q->where('end_hour', '>', request('start'))
                            ->where('end_hour', '<=', request('end'));
                });
        })->get();

        if(count($meetings) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The room is already occupied at that time.';
    }
}
