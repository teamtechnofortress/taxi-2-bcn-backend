<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\Api\LocationController;


// HOME
Route::get('/', function () {
    return view('welcome');
});


// LANGUAGE
Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, ['en', 'fr', 'ar', 'es'])) {

        Session::put('locale', $locale);

    }

    return redirect()->back();

});


// BOOKING CREATE
Route::post(
    '/booking',
    [BookingController::class, 'store']
)->name('booking.store');



// STRIPE SUCCESS
Route::get(
    '/payment/success',
    [BookingController::class, 'success']
)->name('payment.success');


// STRIPE CANCEL
Route::get(
    '/payment/cancel',
    [BookingController::class, 'cancel']
)->name('payment.cancel');



// EMAIL OTP PAGE
Route::get(
    '/verify-email',
    [BookingController::class, 'verifyEmail']
)->name('verify.email');


// VERIFY OTP SUBMIT
Route::post(
    '/verify-email',
    [BookingController::class, 'verifyOtp']
)->name('verify.email.submit');




// STRIPE WEBHOOK
Route::post(
    '/stripe/webhook',
    [StripeWebhookController::class, 'handle']
)->name('stripe.webhook');




// LOCATION AUTOCOMPLETE
Route::get(
    '/api/location/autocomplete',
    [LocationController::class, 'autocomplete']
)->name('location.autocomplete');




// MAIL TEST
Route::get('/test-mail', function () {

    Mail::raw(
        'Testing Email',
        function ($message) {

            $message
                ->to('YOUR_OTHER_EMAIL@gmail.com')
                ->subject('Laravel Test');

        }
    );

    return "Mail Sent";

});