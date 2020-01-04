<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Room;
use App\Operation;

class AdminAreaController extends Controller
{
    public function index()
    {
        $operations = Operation::all();
        $users = User::all()->where('is_active', '1')->sortBy('surname');
        $rooms = Room::all()->where('is_active', '1')->sortBy('name');

        return view('adminArea', compact('users','rooms', 'operations'));
    }

    public function insert_user(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'pwd' => 'required',
            'permission' => 'required',
        ]);

        $user = new User();
        $user->name = request('name');
        $user->surname = request('surname');
        $user->email = request('email');
        $user->password = Hash::make(request('pwd'));
        $user->permission = request('permission');
        $user->save();
        $message_correct = request('name') . " " . request('surname') . " has been correctly inserted!";   
        return redirect()->route('home')->with('success', $message_correct); 
    }

    public function insert_room(Request $request)
    {
        $this->validate($request, [
            'name_room' => 'required',
        ]);
        $room = new Room();
        $room->name = request('name_room');
        $room->save();
        $message_correct = request('name_room') . " has been correctly inserted!";
        return redirect()->route('home')->with('success', $message_correct); 

    }

    public function update_room(Request $request)
    {
        $this->validate($request, [
            'name_room' => 'required',
            'rooms' => 'required',
        ]);
        $room = Room::find(request('rooms'));
        $room->name = request('name_room');
        $room->save();
        $message_correct = request('name_room') . " has been correctly updated!";
        return redirect()->route('home')->with('success', $message_correct); 
    }

    public function delete_room(Request $request)
    {
        $this->validate($request, [
            'name_room' => 'required',
            'rooms' => 'required',
        ]);
        $room = Room::find(request('rooms'));
        $room->is_active = "0";
        $room->save();
        $message_correct = request('name_room') . " has been correctly deleted!";
        return redirect()->route('home')->with('success', $message_correct); 
    }

    public function update_user(Request $request)
    {
        $this->validate($request, [
            'employees' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'pwd' => 'required',
            'permission' => 'required',
        ]);
        $user = User::find(request('employees'));
        $user->name = request('name');
        $user->surname = request('surname');
        $user->email = request('email');
        $user->password = Hash::make(request('pwd'));
        $user->permission = request('permission');
        $user->save();
        $message_correct = request('name') . " " . request('surname') . " has been correctly updated!";
        return redirect()->route('home')->with('success', $message_correct); 
    }

    public function delete_user(Request $request)
    {
        $this->validate($request, [
            'employees' => 'required',
            'name' => 'required',
            'surname' => 'required',
        ]);
        $user = User::find(request('employees'));
        $user->is_active = "0";
        $user->save();
        $message_correct = request('name') . " " . request('surname') . " has been correctly deleted!";
        return redirect()->route('home')->with('success', $message_correct); 
    }

    public function post_employee(Request $request)
    {
        $select = $request->get('emp_selected');
        echo User::find($select);
    }

    public function post_room(Request $request)
    {
        $select = $request->get('room_selected');
        echo Room::find($select);
    }


}
