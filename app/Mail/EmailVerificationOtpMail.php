<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class EmailVerificationOtpMail extends Mailable
{

    public $otp;


    public function __construct($otp)
    {
        $this->otp = $otp;
    }


    public function build()
    {

        return $this
            ->subject('Email Verification OTP')
            ->view('emails.otp');

    }

}