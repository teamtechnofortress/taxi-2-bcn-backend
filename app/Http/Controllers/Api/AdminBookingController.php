<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\BookingRepository;
use Illuminate\Http\Request;

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
   public function index(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $type = $request->input('type');

    return response()->json([
        'status' => true,
        'message' => 'Bookings fetched successfully',
        'data' => $this->repo->getBookings($type, $perPage)
    ]);
}

    // /*
    // ONLY PAID BOOKINGS (STRIPE)
    // */
    // public function paid(Request $request)
    // {
    //     $perPage = $request->input('per_page', 10);
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Paid bookings',
    //         'data' => $this->repo->getPaidBookings($perPage)
    //     ]);
    // }

    // /*
    // ONLY OTP BOOKINGS (OUTSIDE BARCELONA)
    // */
    // public function otp(Request $request)
    // {
    //     $perPage = $request->input('per_page', 10);
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'OTP verified bookings',
    //         'data' => $this->repo->getOtpBookings($perPage)
    //     ]);
    // }
}