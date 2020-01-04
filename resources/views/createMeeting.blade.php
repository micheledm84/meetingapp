@extends('layouts.inside')

@section('content')

<div class="container " id="createMeeting">


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
        @if (isset($id))
            <form action="{{ route('createMeetingUpdateMeeting', ['id' => $id]) }}" method="POST">
            {{ method_field('PUT') }}
        @else
            <form action="{{ route('createMeetingInsertMeeting') }}" method="POST">
        @endif
            @csrf
            <div class="form-group form-row">
                <label for="participants" class="col-sm-2">Participants:</label>
                <select name="participants[]" class="form-control col-sm-6 selectpicker" multiple id="participants">
                    @if (old('participants') != null)
                        @foreach ($users as $user)
                            <option value="{{ $user-> id }}" @if(in_array($user->id, old('participants'))){{ " selected " }} @endif>{{ $user->surname . ' ' . $user->name }}</option>
                        @endforeach
                    @elseif (isset($id))
                        @foreach ($users as $user)
                            @if(in_array($user->id, $participants_arr))
                                <option selected value="{{ $user-> id }}">{{ $user->surname . ' ' . $user->name }}</option>
                            @else 
                                <option value="{{ $user-> id }}">{{ $user->surname . ' ' . $user->name }}</option>
                            @endif
                        @endforeach 
                    @else 
                        @foreach ($users as $user)
                            <option value="{{ $user-> id }}">{{ $user->surname . ' ' . $user->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group form-row">
                <label for="description" class="col-sm-2">Description:</label>
                @if (old('description') !== null)
                    <textarea class="form-control col-sm-6" rows="5" id="description" name="description">{{ old('description') }}</textarea>
                @elseif (isset($id))
                    <textarea class="form-control col-sm-6" rows="5" id="description" name="description">{{ $meeting->description }}</textarea>
                @else
                    <textarea class="form-control col-sm-6" rows="5" id="description" name="description">{{ old('description') }}</textarea>
                @endif
            </div>
            <div class="form-group form-row">
                <label for="room" class="col-sm-2">Room:</label>
                <select name="room" class="form-control col-sm-6" id="room">
                    <!--<option value="0"></option>-->
                    @if (old('room') !== null)
                        @foreach ($rooms as $room)
                            <option value="{{ $room-> id }}" @if(old('room') == $room-> id){{"selected"}} @endif>{{ $room->name }}</option>
                        @endforeach
                    @elseif (isset($id))
                        @foreach ($rooms as $room)
                            @if ($room->id == $meeting->id_room)
                                <option selected value="{{ $room-> id }}">{{ $room->name }}</option>
                            @else
                                <option value="{{ $room-> id }}">{{ $room->name }}</option>
                            @endif
                        @endforeach 
                    @else 
                        @foreach ($rooms as $room)
                            <option value="{{ $room-> id }}" @if(old('room') == $room-> id){{"selected"}} @endif>{{ $room->name }}</option>
                        @endforeach 
                    @endif
                </select>
            </div>
            <div class="form-group form-row">
                <label for="date_meeting" class="col-sm-2">Date:</label>
                @if (old('date_meeting') !== null)
                    <input type="date" class="form-control col-sm-6" id="date_meeting" name="date_meeting" value="{{ old('date_meeting') }}">
                @elseif (isset($id))
                    <input type="date" class="form-control col-sm-6" id="date_meeting" name="date_meeting" value="{{ $meeting->date }}">
                @else
                    <input type="date" class="form-control col-sm-6" id="date_meeting" value = "{{ old('date_meeting') }}" name="date_meeting">
                @endif

            </div>
            <div class="form-group form-row">
                <label for="start" class="col-sm-2">Start Hour:</label>
                @if (old('start') !== null)
                    <input type="time" class="form-control col-sm-6" id="start" name="start" value="{{ old('start') }}">
                @elseif (isset($id))
                    <input type="time" class="form-control col-sm-6" id="start" name="start" value="{{ $meeting->start_hour }}">
                @else
                    <input type="time" class="form-control col-sm-6" value = "{{ old('start') }}" id="start" name="start">
                @endif
            </div>
            <div class="form-group form-row">
                <label for="end" class="col-sm-2">End Hour:</label>
                @if (old('end') !== null)
                    <input type="time" class="form-control col-sm-6" id="end" name="end" value="{{ old('end') }}">
                @elseif (isset($id))
                    <input type="time" class="form-control col-sm-6" id="end" name="end" value="{{ $meeting->end_hour }}">
                @else
                    <input type="time" class="form-control col-sm-6" value = "{{ old('end') }}" id="end" name="end">
                @endif
            </div>
            @if (isset($id))
                <button type="submit" class="btn btn-primary">Update</button>
            @else 
                <button type="submit" class="btn btn-success">Insert</button>
            @endif
        </form>
</div>



@endsection
