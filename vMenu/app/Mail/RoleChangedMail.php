<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RoleChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rolemail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rolemail)
    {
        $this->rolemail = $rolemail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('vmenuteam@gmail.com')
                    ->view('mails.role_changed');
    }
}
