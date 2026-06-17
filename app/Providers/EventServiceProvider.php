<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\PaymentSuccessful;
use App\Listeners\SendPaymentEmail;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentSuccessful::class => [
            SendPaymentEmail::class,
        ],
    ];
    public function boot(): void
    {
        //
    }
}