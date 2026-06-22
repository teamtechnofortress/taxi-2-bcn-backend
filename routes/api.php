<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminBookingController;

/*
| Default User Route (Sanctum)
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('admin')->group(function () {

    // ALL COMPLETED BOOKINGS (OTP + PAYMENT)
    Route::get('/bookings', [AdminBookingController::class, 'index']);

    // ONLY STRIPE PAID BOOKINGS
    Route::get('/bookings/paid', [AdminBookingController::class, 'paid']);

    // ONLY OTP VERIFIED BOOKINGS
    Route::get('/bookings/otp', [AdminBookingController::class, 'otp']);
});