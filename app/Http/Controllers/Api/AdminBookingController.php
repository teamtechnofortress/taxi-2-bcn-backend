<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;

class AdminBookingController extends Controller
{
    protected $repo;

    public function __construct(BookingRepository $repo)
    {
        $this->repo = $repo;
    }

    /*
    ALL COMPLETED BOOKINGS
    */
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'All completed bookings',
            'data' => $this->repo->getCompletedBookings()
        ]);
    }

    /*
    ONLY PAID BOOKINGS (STRIPE)
    */
    public function paid()
    {
        return response()->json([
            'status' => true,
            'message' => 'Paid bookings',
            'data' => $this->repo->getPaidBookings()
        ]);
    }

    /*
    ONLY OTP BOOKINGS (OUTSIDE BARCELONA)
    */
    public function otp()
    {
        return response()->json([
            'status' => true,
            'message' => 'OTP verified bookings',
            'data' => $this->repo->getOtpBookings()
        ]);
    }
}