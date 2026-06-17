<?php

namespace App\Services;

use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class BookingService
{
    protected $bookingRepository;
    protected $paymentRepository;
    protected $stripeService;

    public function __construct(
        BookingRepositoryInterface $bookingRepository,
        PaymentRepositoryInterface $paymentRepository,
        StripeService $stripeService
    ) {
        $this->bookingRepository = $bookingRepository;

        $this->paymentRepository = $paymentRepository;

        $this->stripeService = $stripeService;
    }

    public function createBooking(array $data)
    {
        return $this->bookingRepository
                    ->createBooking($data);
    }

    public function createPayment(array $data)
    {
        return $this->paymentRepository
                    ->createPayment($data);
    }

    public function updatePayment(
        string $sessionId,
        array $data
    ) {
        return $this->paymentRepository
                    ->updatePayment(
                        $sessionId,
                        $data
                    );
    }
    public function createStripeSession(
        $booking,
        $payment
    ) {
        return $this->stripeService
                    ->createCheckoutSession(
                        $booking,
                        $payment
                    );
    }
}