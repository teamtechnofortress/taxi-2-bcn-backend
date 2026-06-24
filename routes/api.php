<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminBookingController;
use App\Http\Controllers\Api\AdminAuthController;

// Admin Login
Route::prefix('admin')->group(function () {

    // GET LOGIN
    Route::get('/login', [AdminAuthController::class, 'login']);

    // Protected booking APIs
    Route::middleware(['auth:sanctum','admin'])->group(function () {

        Route::get('/bookings',
            [AdminBookingController::class,'index']
        );

        Route::get('/bookings/paid',
            [AdminBookingController::class,'paid']
        );

        Route::get('/bookings/otp',
            [AdminBookingController::class,'otp']
        );

    });

});