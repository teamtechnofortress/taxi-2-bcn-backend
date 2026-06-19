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

    // 🔥 ADD THIS (IMPORTANT)
    $payment->booking->update([
        'status' => 'completed',
        'completion_type' => 'payment',
    ]);

    event(new \App\Events\PaymentSuccessful($payment));
}
}