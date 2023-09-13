<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class quotationMail extends Mailable 
{
    use Queueable, SerializesModels;
    public $quote;
    public $tries = 5;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $quote = $this->quote;
        return $this->view('mail.quotation',compact('quote'));
    }
}
