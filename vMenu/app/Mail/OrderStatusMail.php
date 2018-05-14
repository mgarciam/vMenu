<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ordermail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ordermail)
    {
        $this->ordermail = $ordermail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('vmenuteam@gmail.com')
                    ->view('mails.order_status');
    }
}
