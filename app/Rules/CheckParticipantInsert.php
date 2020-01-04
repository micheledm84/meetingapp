<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;
use App\User;



class CheckParticipantInsert implements Rule
{
    protected $participants_occupied = array();


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
        $participants = request('participants');

        if (request('start') == null || request('end') == null) {
            return true;
        }

        foreach($participants as $participant) {

            $meetings = DB::table('meetings')
            ->where('is_active', '1')
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
            })
            ->where(function ($query) use($participant) {
                $query->where('id_participants', $participant)
                    ->orWhere('id_participants', 'like', '%;'.$participant)
                    ->orWhere('id_participants', 'like', $participant.';%')
                    ->orWhere('id_participants', 'like', '%;'.$participant.';%');
            })
            ->get();

            if(count($meetings) > 0) {
                array_push($this->participants_occupied, $participant);
            }
        }

        if(count($this->participants_occupied) > 0) {
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
        $arr_names = array(); //I created this array

        for($i = 0; $i < count($this->participants_occupied); $i++) {
            array_push($arr_names, $this->getNameSurnameById($this->participants_occupied[$i]));
        }

        return 'The following participants are already occupied at that time: ' . implode(', ', $arr_names) . '.';


    }

    public function getNameSurnameById($id)
    {
        $users = User::all()->where('id', $id)->first(); 

        return $users->name . " " . $users->surname;
    }

}
