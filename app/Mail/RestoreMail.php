<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestoreMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $restore;
    public function __construct($restore)
    {
        $this->restore = $restore;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $item = $this->restore->item;
        return $this->view('mails.restore')->subject("Your $item has been restored successfully");

    }
}