<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{
    /*
    CREATE BOOKING (YOU ALREADY HAVE THIS)
    */
    public function createBooking(array $data)
    {
        return Booking::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'passengers' => $data['passengers'],

            // PICKUP
            'pickup_address' => $data['pickup_address'],
            'pickup_lat' => $data['pickup_lat'],
            'pickup_lng' => $data['pickup_lng'],
            'pickup_city' => $data['pickup_city'] ?? null,

            // DROPOFF
            'dropoff_address' => $data['dropoff_address'],
            'dropoff_lat' => $data['dropoff_lat'],
            'dropoff_lng' => $data['dropoff_lng'],
            'dropoff_city' => $data['dropoff_city'] ?? null,

            'travel_date' => $data['travel_date'],
            'travel_time' => $data['travel_time'],

            'status' => $data['status'],
            'completion_type' => $data['completion_type'],
        ]);
    }

    /*
    ADMIN READ APIs
    */
   public function getBookings($type = null, $perPage = 10)
    {
        $query = Booking::with('payment')
            ->where('status', 'completed');

        if ($type === 'payment') {
            $query->where('completion_type', 'payment');
        }

        if ($type === 'otp') {
            $query->where('completion_type', 'otp');
        }

        return $query->latest()->paginate($perPage);
    }
}