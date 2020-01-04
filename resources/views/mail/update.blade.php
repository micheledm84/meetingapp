<!DOCTYPE html>
<html>
<body>

<p>Hi <b>{{ $full_name }}</b>,</p>
<br>
<p>The meeting you were invited has been <b>updated</b> as follows:</p>
<br>
<hr>
<p>Date: <b>{{ $date_meeting }}</b></p>
<p>Participants: <b>{{ $participants }}</b></p>
<p>Start: <b>{{ $start }}</b></p>
<p>End: <b>{{ $end }}</b></p>
<p>Room: <b>{{ $room }}</b></p>
<p>Description: <b>{{ $description }}</b></p>
<hr>
<br>
<p>Yours Sincerely,</p>
<br>
<p>Meeting Staff</p>

</body>
</html>