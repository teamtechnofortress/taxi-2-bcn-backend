<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Api\LocationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, ['en', 'fr', 'ar', 'es'])) {
        Session::put('locale', $locale);
    }

    return redirect()->to(url()->previous());
});
Route::post('/booking', [BookingController::class, 'store']);


Route::get(
    '/payment/success',
    [BookingController::class, 'success']
);

Route::get(
    '/payment/cancel',
    [BookingController::class, 'cancel']
);


Route::get('/test-mail', function () {

    Mail::raw('Testing Email', function ($message) {

        $message->to('YOUR_OTHER_EMAIL@gmail.com')
                ->subject('Laravel Test');
    });

    return 'Mail Sent';
});

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::get(
    '/api/location/autocomplete',
    [LocationController::class, 'autocomplete']
);

Route::get('/verify-email', [BookingController::class, 'verifyEmail'])
    ->name('verify.email');

Route::post('/verify-email', [BookingController::class, 'verifyOtp']);