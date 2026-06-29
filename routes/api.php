<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminBookingController;


Route::prefix('admin')->group(function () {


    Route::post('/login',
        [AdminAuthController::class,'login']
    );


    Route::middleware(['auth:sanctum','admin'])->group(function(){


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