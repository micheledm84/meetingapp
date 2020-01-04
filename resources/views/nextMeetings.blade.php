@extends('layouts.inside')

@section('content')
<!--
<div class="offset-md-2">
        <p class="text-dark h6"><strong><em>The next Meetings</em></strong></p>
</div>
<hr>-->

<div class="container table-responsive">
  <table class="table table-condensed table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Participants</th>
        <th>Description</th>
        <th>Room</th>
        <th>Date</th>
        <th>Start Hour</th>
        <th>End Hour</th>
        @if (Auth::user()->permission != 0)
          <th>Edit</th>
          <th>Delete</th>
        @endif
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
                @if (Auth::user()->permission != 0)
                  <td><a href="{{ route('updateMeeting', ['id' => $meeting->id]) }}" class= "text-center"><button type="button" class="btn btn-primary">Edit</button></a></td>
                  <td>
                    <form action="{{ route('nextMeetingsDeleteMeeting', ['id' => $meeting->id]) }}" method="POST">
                    @csrf
                    {{ method_field('PUT') }}
                    <button type="submit" class="btn btn-danger" id={{ $meeting->id }}>Delete</button>
                    </form>
                  </td>
                @endif

            </tr>
        @endforeach
    </tbody>
  </table>
  <div class="row justify-content-center">
    {{ $meetings->links() }}
  </div>


 
</div>


@endsection