<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Room;
use App\Meeting;
use DB;

date_default_timezone_set('Europe/Rome');


class ReportAreaController extends Controller
{
    public function index()
    {
        $rooms = Room::all()->sortBy('name');
        $users = User::all()->where('is_active', '1')->sortBy('surname'); 

        return view('reportArea', compact('users','rooms'));
    }

    public function fetch_table(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'date',
            'end_date' => 'date',
        ]);

        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $participants = $request['participants'];
        $room_input = $request['rooms'];

        $rooms = Room::all();
        $users = User::all()->where('is_active', '1')->sortBy('surname');

        $meetings = $this->build_table($room_input, $start_date, $end_date, $participants);

        $this->getUsersTable($meetings);
        $this->getRoomsTable($meetings);

        return view('reportArea', compact('users','rooms','meetings','start_date','end_date','participants','room_input'));//->withInput($request->all());
    }

    public function build_table($room, $start_date, $end_date, $participants)
    {
        if (!empty($room) && !empty($participants)) {
            $meetings = DB::table('meetings')
            ->where('is_active', '1')
            ->orderBy('date')
            ->orderBy('start_hour')
            ->orderBy('end_hour')
            ->where('id_room', $room)
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->where(function ($query) use($participants) {
                $query->where('id_participants', $participants)
                    ->orWhere('id_participants', 'like', '%;'.$participants)
                    ->orWhere('id_participants', 'like', $participants.';%')
                    ->orWhere('id_participants', 'like', '%;'.$participants.';%');
            })
            ->paginate(5);
        } elseif (!empty($participants)) {
            $meetings = DB::table('meetings')
            ->where('is_active', '1')
            ->orderBy('date')
            ->orderBy('start_hour')
            ->orderBy('end_hour')
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->where(function ($query) use($participants) {
                $query->where('id_participants', $participants)
                    ->orWhere('id_participants', 'like', '%;'.$participants)
                    ->orWhere('id_participants', 'like', $participants.';%')
                    ->orWhere('id_participants', 'like', '%;'.$participants.';%');
            })
            ->paginate(5);
        } elseif (!empty($room)) {
            $meetings = DB::table('meetings')
            ->where('is_active', '1')
            ->orderBy('date')
            ->orderBy('start_hour')
            ->orderBy('end_hour')
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->where('id_room', $room)
            ->paginate(5);
        } else {
            $meetings = DB::table('meetings')
            ->where('is_active', '1')
            ->orderBy('date')
            ->orderBy('start_hour')
            ->orderBy('end_hour')
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->paginate(5);
        }

        return $meetings;
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
}
