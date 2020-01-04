<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
use App\User;
use App\Room;
use Carbon\Carbon;
use DB;
use App\Mail\DeleteMeetingMail;


date_default_timezone_set('Europe/Rome');


class NextMeetingsController extends Controller
{
    public function index()
    {

        $meetings = DB::table('meetings')
        ->where('is_active', '1')
        ->orderBy('date')
        ->orderBy('start_hour')
        ->orderBy('end_hour')
        ->where(function ($query) {
            $query->where('date', '>', date("Y-m-d"))
                ->orWhere(function($sub_q) {
                    $sub_q->where('date', '=', date("Y-m-d"))
                    ->where('end_hour', '>=', date("H:i:s"));
                });
        })->paginate(5);

        $this->getUsersTable($meetings);
        $this->getRoomsTable($meetings);

        return view('nextMeetings', compact('meetings'));
    }

    public function getUsersTable($meetings)
    {
        foreach ($meetings as $meeting) {
            $meeting_arr = explode(";", $meeting->id_participants);
            for($i = 0; $i < count($meeting_arr); $i++) {
                $meeting_arr[$i] = $this->getNameSurnameById($meeting_arr[$i]);
            }
            $meeting->id_participants = implode("; ", $meeting_arr);

        }
    }

    public function getRoomsTable($meetings)
    {
        foreach ($meetings as $meeting) {
            $rooms = Room::all()->where('id', $meeting->id_room)->first();
            $meeting->id_room = $rooms->name;

        }
    }

    public function getNameSurnameById($id)
    {
        $users = User::all()->where('id', $id)->first();

        $name = $users->name;
        $surname = $users->surname;
        $full_name = $name . " " . $surname;
        return $full_name;
    }

    public function delete_meeting($id)
    {
        $meeting = Meeting::find($id);
        $meeting->is_active = "0";
        $meeting->save();

        $mail_response = $this->send_mail_delete($meeting);
        
        if($mail_response) {
            $message_correct = "The meeting has been correctly deleted. The emails to advise the participants have been sent.";
            return redirect()->route('home')->with('success', $message_correct); 
        } else {
            $message_correct = "The meeting has been correctly deleted.";
            $mail_not_sent = "The emails to advise the participants could not be sent";
            return redirect()->route('home')->with('success', $message_correct)->with('mail_not_sent', $mail_not_sent);
        }
    }

    public function send_mail_delete($meeting)
    {
        $participants_delete = (explode(";",$meeting->id_participants));
        $participants_mail = $this->convertIdToName(explode(";",$meeting->id_participants));

        foreach($participants_delete as $participant_id) {
            sleep(4);
            $mail_create = $this->find_user_mail($participant_id);
            $full_name_mail = $this->getNameSurnameById($participant_id);
            $name_room = $this->getRoomName($meeting->id_room);
            $description = $meeting->description;
            $date = $meeting->date;
            $start = $meeting->start_hour;
            $end = $meeting->end_hour;
            try {
            \Mail::to($mail_create)->send(new DeleteMeetingMail($participants_mail, $description,
            $name_room, $date, $start, $end, $full_name_mail));
            }
            catch (\Exception $e){
                return false;
            }
        }
        return true;
    }

    public function getRoomName($id)
    {
            $room = Room::all()->where('id', $id)->first();
            $room_name = $room->name;
            return $room_name;

        
    }

    public function find_user_mail($id)
    {
        $user = User::find($id);
        $email = $user->email;
        return $email;
    }

    public function convertIdToName($arr_id)
    {
        $arr_names = array();

        foreach($arr_id as $participant_id) {
            $full_name = $this->getNameSurnameById($participant_id);
            array_push($arr_names, $full_name);
        }

        $names_participants = implode(", ", $arr_names);

        return $names_participants;
    }
}
