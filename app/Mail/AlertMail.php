<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlertMail extends Mailable
{
    use Queueable, SerializesModels;
    public $itemName,$quantity;
    /**
     * Create a new message instance.
     */
    public function __construct($itemName,$quantity)
    {
        $this->itemName=$itemName;
        $this->quantity=$quantity;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alert Mail',
        );
    }

    public function build()
    {
        return $this->view('email.alert');
    }
}
