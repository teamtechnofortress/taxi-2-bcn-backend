<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(
            config('services.stripe.secret')
        );
    }
    public function createCheckoutSession(
        Booking $booking,
        Payment $payment
    ): Session {
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $payment->currency,
                    'product_data' => [
                        'name' => 'Taxi Booking',
                    ],
                    'unit_amount' => $payment->amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' =>
                url('/payment/success')
                . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' =>
                url('/payment/cancel'),
            'metadata' => [
    'booking_id' => $booking->id,
    'payment_id' => $payment->id,
],
'payment_intent_data' => [
    'metadata' => [
        'payment_id' => $payment->id,
        'booking_id' => $booking->id,
    ]
]
        ]);
    }
}