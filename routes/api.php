<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminBookingController;
use App\Http\Controllers\Api\AdminNotificationController;

Route::prefix('admin')->group(function () {

    Route::post(
        '/login',
        [AdminAuthController::class, 'login']
    );

    Route::middleware(['auth:sanctum', 'admin'])->group(function () {

        Route::get(
            '/bookings',
            [AdminBookingController::class, 'index']
        );

        Route::post(
            '/notification-token',
            [AdminNotificationController::class, 'storeToken']
        );

    });

});