<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingReceivedMail;

class SendPaymentEmail
{
    public function handle(PaymentSuccessful $event)
    {
        Log::info('PaymentSuccessful event triggered', [
            'payment_id' => $event->payment->id ?? null,
            'booking_id' => $event->payment->booking->id ?? null,
        ]);

        try {
            $email = $event->payment->booking->email ?? null;

            Log::info('Preparing to send booking email', [
                'email' => $email,
            ]);

            Mail::to($email)
                ->send(new BookingReceivedMail(
                    $event->payment->booking
                ));

            Log::info('Booking email sent successfully', [
                'email' => $email,
            ]);

        } catch (\Exception $e) {

            Log::error('Failed to send booking email', [
                'error' => $e->getMessage(),
                'payment_id' => $event->payment->id ?? null,
            ]);
        }
    }
}