@extends('layouts.inside')

@section('content')
<!--
<div class="offset-md-2">
        <p class="text-dark h6"><strong><em>Create a Report</em></strong></p>
</div>
<hr>-->

    <div class="row justify-content-center">
        <div class="col-md-8">
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
        </div>
    </div>
    <form action=" {{ route('reportAreaFetchTable') }} " method="GET">
    @csrf
        <div class="d-flex flex-column flex-sm-row justify-content-around" >
            <div>
                Participant
            </div>
            <div>
                <select id="participants" name="participants">
                    <option value="">All</option>
                    @foreach ($users as $user)
                        @if (isset($participants))
                            @if ( $participants == $user->id )
                                <option selected value="{{ $user->id }}">{{ $user->surname . " " . $user->name}}</option>
                            @else 
                                <option value="{{ $user->id }}">{{ $user->surname . " " . $user->name}}</option>
                            @endif
                        @else
                            <option value="{{ $user->id }}">{{ $user->surname . " " . $user->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div>
                Start Date
            </div>
            <div>
                @if (isset($start_date))
                    <input type="date" value="{{ $start_date }}" name="start_date" id="start_date">
                @else
                    <input type="date" name="start_date" id="start_date">
                @endif
            </div>
            <div>
                End Date
            </div>
            <div>
                @if (isset($end_date))
                    <input type="date" value="{{ $end_date }}" name="end_date" id="end_date">
                @else
                    <input type="date" name="end_date" id="end_date">
                @endif            
            </div>
            <div>
                Room
            </div>
            <div>
                <select id="rooms" name="rooms">
                    <option value="">All</option>
                    @foreach ($rooms as $room)
                        @if (isset($room_input))
                            @if ( $room_input == $room->id )
                                <option selected value="{{ $room->id }}">{{ $room->name }}</option>
                            @else 
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endif
                        @else
                            <option value="{{ $room->id }}">{{ $room->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
                <button type="submit" class="btn btn-success" id="check_report">Search</button>
            </div>
            <hr>
        </div>
    </form>
    @if (isset($meetings))
        <div class="container table-responsive">
            <table class="table table-condensed table-bordered table-hover ">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Participants</th>
                    <th>Description</th>
                    <th>Room</th>
                    <th>Date</th>
                    <th>Start Hour</th>
                    <th>End Hour</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($meetings as $meeting)
                        <tr>
                            <td>{{ $meeting->id }}</td>
                            <td>{{ $meeting->id_participants }}</td>
                            <td>{{ $meeting->description }}</td>
                            <td>{{ $meeting->id_room }}</td>
                            <td>{{ $meeting->date }}</td>
                            <td>{{ substr($meeting->start_hour,0,5) }}</td>
                            <td>{{ substr($meeting->end_hour,0,5) }}</td>
                            <td><a href="{{ route('updateMeeting', ['id' => $meeting->id]) }}" class= "text-center"><button type="button" class="btn btn-primary">Edit</button></a></td>
                            <td>
                            <form action="{{ route('nextMeetingsDeleteMeeting', ['id' => $meeting->id]) }}" method="POST">
                            @csrf
                            {{ method_field('PUT') }}
                            <button type="submit" class="btn btn-danger" id={{ $meeting->id }}>Delete</button>
                            </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center">
                {{ $meetings->appends(request()->query())->links() }}
            </div>
        </div>

    @endif

@endsection

