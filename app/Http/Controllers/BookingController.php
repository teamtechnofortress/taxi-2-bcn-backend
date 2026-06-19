<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookingService;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReceivedMail;
use App\Models\EmailOtp;
use App\Models\Booking;
use App\Mail\EmailVerificationOtpMail;
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
        CHECK LOCATION
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

        Log::info('RAW LOCATIONIQ RESULT', [
            'pickupCity' => $pickupCity,
            'dropoffCity' => $dropoffCity,
        ]);

        $pickupInside = $this->isAllowedCity($pickupCity);
        $dropoffInside = $this->isAllowedCity($dropoffCity);

        Log::info('CITY CHECK RESULT', [
            'pickupInside' => $pickupInside,
            'dropoffInside' => $dropoffInside,
        ]);

        $validated['pickup_city'] = $pickupCity;
        $validated['dropoff_city'] = $dropoffCity;

        /*
        STRIPE FLOW
        */
       if (!$pickupInside || !$dropoffInside) {

    Log::info('OTP FLOW TRIGGERED');

    $booking = $this->bookingService->createBooking([
        ...$validated,
        'status' => 'processing',
        'completion_type' => 'otp'
    ]);

    Log::info('BOOKING CREATED (OTP)', ['id' => $booking->id]);

    $otp = rand(1000, 9999);

    EmailOtp::updateOrCreate(
        ['email' => $validated['email']],
        [
            'otp' => $otp,
            'expires_at' => now()->addMinutes(2),
            'verified' => false
        ]
    );

    Log::info('OTP GENERATED', [
        'email' => $validated['email'],
        'otp' => $otp
    ]);

    Mail::to($validated['email'])
        ->send(new EmailVerificationOtpMail($otp));

    session([
        'booking_id' => $booking->id,
        'outside_city_verification' => true
    ]);

    return redirect()->route('verify.email');
}

        /*
        OTP FLOW
        */
        Log::info('OTP FLOW TRIGGERED');

        $booking = $this->bookingService->createBooking([
            ...$validated,
            'status' => 'processing',
            'completion_type' => 'otp'
        ]);

        Log::info('BOOKING CREATED (OTP)', ['id' => $booking->id]);

        $otp = rand(1000, 9999);

        EmailOtp::updateOrCreate(
            ['email' => $validated['email']],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(2),
                'verified' => false
            ]
        );

        Log::info('OTP GENERATED', [
            'email' => $validated['email'],
            'otp' => $otp
        ]);

        Mail::to($validated['email'])
            ->send(new EmailVerificationOtpMail($otp));

        session([
            'booking_id' => $booking->id,
            'outside_city_verification' => true
        ]);

        return redirect()->route('verify.email');
    }

    private function isAllowedCity($city)
    {
        if (!$city) {
            Log::warning('CITY NULL');
            return false;
        }

        $allowedCities = config('locationiq.allowed_cities');

        Log::info('ALLOWED CITIES CONFIG', $allowedCities);

        $city = strtolower(trim($city));

        foreach ($allowedCities as $allowedCity) {

            $allowedCity = strtolower(trim($allowedCity));

            if ($city == $allowedCity) {

                Log::info('CITY MATCHED', [
                    'city' => $city,
                    'allowed' => $allowedCity
                ]);

                return true;
            }
        }

        Log::info('CITY NOT ALLOWED', [
            'city' => $city
        ]);

        return false;
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);
        Log::info('OTP VERIFY ATTEMPT', $request->all());

        $bookingId = session('booking_id');

        if (!$bookingId) {
            Log::error('SESSION EXPIRED');
            return redirect('/')->with('error', 'Session expired');
        }

        $booking = Booking::find($bookingId);

        if (!$booking) {
            Log::error('BOOKING NOT FOUND');
            return redirect('/')->with('error', 'Booking not found');
        }

        $otp = EmailOtp::where('email', $booking->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            Log::warning('INVALID OTP');
            return back()->with('error', 'Invalid or expired OTP');
        }

        $otp->update(['verified' => true]);

        $booking->update([
            'status' => 'completed',
            'completion_type' => 'otp'
        ]);

        Log::info('OTP FLOW COMPLETED');

        session()->forget('outside_city_verification');
        session()->forget('booking_id');

        
        return redirect('/')
            ->with(
                'outside_city',
                'You are outside Barcelona city. Our driver will contact you shortly.'
            );
    }

    public function verifyEmail()
    {
        if (!session('outside_city_verification')) {
            return redirect('/');
        }

        return view('verify-email');
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