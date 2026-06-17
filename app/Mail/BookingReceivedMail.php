<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class BookingReceivedMail extends Mailable
{
    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Booking Received')
                    ->view('emails.booking-received');
    }
}