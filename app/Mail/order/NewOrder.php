<?php

namespace App\Mail\order;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $order_details;
    public function __construct($order_details)
    {
        $this->order_details = $order_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tx_ref = $this->order_details->wefarm_tx_ref;
        return $this->view('mails.order.newOrder')->subject("Order $tx_ref received");
    }
}