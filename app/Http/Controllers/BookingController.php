<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookingService;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationOtpMail;
use App\Models\EmailOtp;
use App\Models\Booking;
use App\Services\Location\LocationReverseGeocodingService;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function store(Request $request)
    {
        Log::info('BOOKING STARTED', $request->all());

        $validated = $request->validate([

            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'passengers' => 'required|integer|min:1|max:10',

            'pickup_address' => 'required',
            'pickup_lat' => 'required',
            'pickup_lng' => 'required',

            'dropoff_address' => 'required',
            'dropoff_lat' => 'required',
            'dropoff_lng' => 'required',

            'travel_date' => 'required|date|after_or_equal:today',
            'travel_time' => 'required',
        ]);

        Log::info('VALIDATION PASSED', $validated);
        /*
        | CHECK LOCATION
        */
        $geo = app(LocationReverseGeocodingService::class);
        $pickupCity = $geo->getCity(
            $validated['pickup_lat'],
            $validated['pickup_lng']
        );

        $dropoffCity = $geo->getCity(
            $validated['dropoff_lat'],
            $validated['dropoff_lng']
        );

        $pickupInside = $this->isAllowedCity($pickupCity);
        $dropoffInside = $this->isAllowedCity($dropoffCity);
Log::info('LOCATION CHECK', [
    'pickup_city' => $pickupCity,
    'dropoff_city' => $dropoffCity,
    'pickup_inside' => $this->isAllowedCity($pickupCity),
    'dropoff_inside' => $this->isAllowedCity($dropoffCity),
]);
    
        /*
        | INSIDE BARCELONA FLOW
        */
        if($pickupInside && $dropoffInside)
        {
            $booking = $this->bookingService->createBooking([
                ...$validated,
                'status' => 'processing',
                'completion_type' => 'payment'
            ]);

            $payment = $this->bookingService->createPayment([
                'booking_id' => $booking->id,
                'amount' => 6000,
                'currency' => 'eur',
                'status' => 'pending'
            ]);
            $session = $this->bookingService->createStripeSession(
                $booking,
                $payment
            );
            $payment->update([
                'stripe_session_id' => $session->id
            ]);
            return redirect($session->url);
        }
        /*
        | OUTSIDE BARCELONA FLOW

        */
        $booking = $this->bookingService->createBooking([
            ...$validated,
            'status' => 'processing',
            'completion_type' => 'otp'
        ]);
        $otp = rand(1000,9999);
        EmailOtp::updateOrCreate(
            [
                'email' => $validated['email']
            ],

            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(2),
                'verified' => false
            ]

        );

        Mail::to($validated['email'])
            ->send(
                new EmailVerificationOtpMail($otp)
            );
        session([

            'booking_id' => $booking->id,
            'outside_city_verification' => true

        ]);

        return redirect()
            ->route('verify.email');
    }
    public function verifyOtp(Request $request)
    {

        $request->validate([
            'otp' => 'required'
        ]);
        $bookingId = session('booking_id');
        if(!$bookingId)
        {
            return redirect('/')
                ->with(
                    'error',
                    'Session expired'
                );

        }
        $booking = Booking::find($bookingId);
        if(!$booking)
        {
            return redirect('/')
                ->with(
                    'error',
                    'Booking not found'

                );
        }
        $otp = EmailOtp::where('email',$booking->email)
            ->where('otp',$request->otp)

            ->where(
                'expires_at',

                '>',

                now()
            )
            ->first();
        if(!$otp)
        {
            return back()
                ->with(
                    'error',
                    'Invalid or expired OTP'
                );
        }

        // OTP verified
        $otp->update([
            'verified' => true
        ]);

        // Update existing booking

        $booking->update([
            'status' => 'completed',
            'email_verified' => true,
            'completion_type' => 'otp'

        ]);
Log::info('BOOKING UPDATED', $booking->toArray());
        session()->forget('booking_id');
        session()->forget('outside_city_verification');

        return redirect('/')
            ->with(
                'outside_city',
                'You are outside Barcelona city. Our driver will contact you shortly.'
            );
    }
    public function verifyEmail()
    {
        if(!session('outside_city_verification'))
        {
            return redirect('/');
        }
        return view('verify-email');
    }
    private function isAllowedCity($city)
    {
        if(!$city)
        {
            return false;
        }
        $allowedCities = config('locationiq.allowed_cities');
        $city = strtolower(trim($city));
        foreach($allowedCities as $allowedCity)
        {
            $allowedCity = strtolower(trim($allowedCity));
            if($city == $allowedCity)
            {
                return true;
            }
        }
        return false;
    }
    public function success()
    {
        return view('success');
    }
    public function cancel()
    {
        return view('cancel');
    }
}