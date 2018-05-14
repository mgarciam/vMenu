<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookedRoomMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookedmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bookedmail)
    {
        $this->bookedmail = $bookedmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('vmenuteam@gmail.com')
                    ->view('mails.booked_room');
    }
}
