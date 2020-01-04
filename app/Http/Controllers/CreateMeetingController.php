<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;
use App\Meeting;
use App\Rules\CheckRoomUpdate;
use App\Rules\CheckParticipantUpdate;
use App\Rules\CheckRoomInsert;
use App\Rules\CheckParticipantInsert;
use App\Rules\CheckDateTime;
use App\Rules\CheckTime;
use App\Mail\CreateMeetingMail;
use App\Mail\UpdateMeetingMail;



class CreateMeetingController extends Controller
{
    public function index()
    {
        $rooms = Room::all()->where('is_active', '1')->sortBy('name');
        $users = User::all()->where('is_active', '1')->sortBy('surname'); 

        return view('createMeeting', compact('users','rooms'));
    }

    public function update($id)
    {
        $rooms = Room::all();
        $users = User::all()->sortBy('surname'); 
        $meeting = Meeting::where('id', $id)->first();

        $participants_arr = explode(";", $meeting->id_participants);

        return view('createMeeting', compact('users','rooms', 'id', 'meeting', 'participants_arr'));
    }

    public function insert_meeting(Request $request)
    {

        $this->validate($request, [
            'participants' => [ 'required', new CheckParticipantInsert() ], 
            'description' => 'required',
            'room' => [ 'required', new CheckRoomInsert() ],
            'date_meeting' => [ 'required', new CheckDateTime() ],
            'start' => [ 'required', new CheckTime() ],
            'end' => 'required',
        ]);
/*
        $this->validate($request, [
            'participants' => [ 'required', new CheckParticipantInsert() ], 
            'description' => 'required',
            'room' => [ 'required', new CheckRoomInsert() ],
            'date_meeting' => [ 'required', new CheckDateTime() ],
            'start' => [ 'required', new CheckTime() ],
            'end' => 'required',
        ]);*/

        $participants_mail = $this->convertIdToName(request('participants'));

        $mail_response = $this->send_mail_create($request, $participants_mail);

        $meeting = new Meeting();
 
        $participants = request('participants');
        $meeting->id_participants = implode(';', $participants);

        $meeting->description = request('description');
        $meeting->id_room = request('room');
        $meeting->date = request('date_meeting');
        $meeting->start_hour = request('start');
        $meeting->end_hour = request('end');

        $meeting->save();

        if($mail_response) {
            $message_correct = "The meeting has been correctly inserted. The emails to advise the participants have been sent.";
            return redirect()->route('home')->with('success', $message_correct); 
        } else {
            $message_correct = "The meeting has been correctly inserted.";
            $mail_not_sent = "The emails to advise the participants could not be sent";
            return redirect()->route('home')->with('success', $message_correct)->with('mail_not_sent', $mail_not_sent);
        }

    }

    public function update_meeting(Request $request, $id)
    {

        $this->validate($request, [
            'participants' => [ 'required', new CheckParticipantUpdate($id) ], 
            'description' => 'required',
            'room' => [ 'required', new CheckRoomUpdate($id) ],
            'date_meeting' => [ 'required', new CheckDateTime() ],
            'start' => [ 'required', new CheckTime() ],
            'end' => 'required',
        ]);

        $participants_mail = $this->convertIdToName(request('participants'));

        $mail_response = $this->send_mail_update($request, $participants_mail);

        $meeting = Meeting::find($id);
 
        $participants = request('participants');
        $meeting->id_participants = implode(';', $participants);

        $meeting->description = request('description');
        $meeting->id_room = request('room');
        $meeting->date = request('date_meeting');
        $meeting->start_hour = request('start');
        $meeting->end_hour = request('end');

        $meeting->save();

        if($mail_response) {
            $message_correct = "The meeting has been correctly updated. The emails to advise the participants have been sent.";
            return redirect()->route('home')->with('success', $message_correct); 
        } else {
            $message_correct = "The meeting has been correctly updated.";
            $mail_not_sent = "The emails to advise the participants could not be sent";
            return redirect()->route('home')->with('success', $message_correct)->with('mail_not_sent', $mail_not_sent);
        }

    }

    public function find_user_mail($id)
    {
        $user = User::find($id);
        $email = $user->email;
        return $email;
    }

    public function send_mail_create($request, $participants_mail)
    {
        foreach(request('participants') as $participant_id) {
            sleep(4);
            $mail_create = $this->find_user_mail($participant_id);
            $full_name_mail = $this->getNameSurnameById($participant_id);
            $name_room = $this->getRoomName(request('room'));
            try {
            \Mail::to($mail_create)->send(new CreateMeetingMail($participants_mail,request('description'),
            $name_room,request('date_meeting'),request('start'),request('end'), $full_name_mail));
            }
            catch (\Exception $e){
                return false;
            }
        }
        return true;
    }

    public function send_mail_update($request, $participants_mail)
    {
        foreach(request('participants') as $participant_id) {
            sleep(4);
            $mail_create = $this->find_user_mail($participant_id);
            $full_name_mail = $this->getNameSurnameById($participant_id);
            $name_room = $this->getRoomName(request('room'));
            try {
            \Mail::to($mail_create)->send(new UpdateMeetingMail($participants_mail,request('description'),
            $name_room,request('date_meeting'),request('start'),request('end'), $full_name_mail));
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

    public function getNameSurnameById($id)
    {
        $users = User::all()->where('id', $id)->first();

        $name = $users->name;
        $surname = $users->surname;
        $full_name = $name . " " . $surname;

        return $full_name;
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
