<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FarewellEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $farewellmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($farewellmail)
    {
        $this->farewellmail = $farewellmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('vmenuteam@gmail.com')
                    ->view('mails.farewell');
    }
}
