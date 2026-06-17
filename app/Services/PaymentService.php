<?php

namespace App\Services;
use App\Models\Payment;

class PaymentService
{
    public function markAsPaid(Payment $payment): void
    {
        $payment->update([
            'status' => 'paid',
        ]);
        event(new \App\Events\PaymentSuccessful($payment));
    }
}