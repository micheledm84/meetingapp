@extends('layouts.inside')

@section('content')
<div class="container col-sm-8" id="createMeeting">
    
        <p class="text-danger lead"><strong><em>Edit the Meeting</em></strong></p>
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    <em>ERRORS: The operation could not be done!</em>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('createMeetingInsertMeeting') }}" method="POST">
            @csrf
            <div class="form-group form-row">
                <label for="participants" class="col-sm-2">Participants:</label>
                <select name="participants[]" class="form-control col-sm-6 selectpicker" multiple id="participants">

                    @foreach ($users as $user)
                    <option value="{{ $user-> id }}">{{ $user->surname . ' ' . $user->name }}</option>
                    @endforeach 
                </select>
            </div>
            <div class="form-group form-row">
                <label for="description" class="col-sm-2">Description:</label>
                <textarea class="form-control col-sm-6" rows="5" id="description" name="description"></textarea>
            </div>
            <div class="form-group form-row">
                <label for="room" class="col-sm-2">Room:</label>
                <select name="room" class="form-control col-sm-6" id="room">
                    <option value="0"></option>
                    @foreach ($rooms as $room)
                    <option value="{{ $room-> id }}">{{ $room->name }}</option>
                    @endforeach 
                </select>
            </div>
            <div class="form-group form-row">
                <label for="date_meeting" class="col-sm-2">Date:</label>
                <input type="date" class="form-control col-sm-6" id="date_meeting" name="date_meeting">

            </div>
            <div class="form-group form-row">
                <label for="start" class="col-sm-2">Start Hour:</label>
                <input type="time" class="form-control col-sm-6" id="start" name="start">
            </div>
            <div class="form-group form-row">
                <label for="end" class="col-sm-2">End Hour:</label>
                <input type="time" class="form-control col-sm-6" id="end" name="end">
            </div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
</div>



@endsection
