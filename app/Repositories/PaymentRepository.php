<?php

namespace App\Repositories;
use App\Models\Payment;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function createPayment(array $data)
    {
        return Payment::create($data);
    }
    public function updatePayment(
        string $sessionId,
        array $data
    ) {
        return Payment::where(
            'stripe_session_id',
            $sessionId
        )->update($data);
    }
}