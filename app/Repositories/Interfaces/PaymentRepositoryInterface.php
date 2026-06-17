<?php

namespace App\Repositories\Interfaces;

interface PaymentRepositoryInterface
{
    public function createPayment(array $data);

    public function updatePayment(
        string $sessionId,
        array $data
    );
}