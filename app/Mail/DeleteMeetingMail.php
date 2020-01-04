<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeleteMeetingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $participants;
    public $description;
    public $room;
    public $date_meeting;
    public $start;
    public $end;
    public $full_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($participants, $description, $room, $date_meeting, $start, $end, $full_name)
    {
        $this->participants = $participants;
        $this->description = $description;
        $this->room = $room;
        $this->date_meeting = $date_meeting;
        $this->start = $start;
        $this->end = $end;
        $this->full_name = $full_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Meeting Deleted';
        return $this->subject($subject)->view('mail.delete');
    }
}
