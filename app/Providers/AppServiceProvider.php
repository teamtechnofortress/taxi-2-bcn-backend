<?php

namespace App\Providers;

use App\Repositories\BookingRepository;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\PaymentRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BookingRepositoryInterface::class,
            BookingRepository::class
        );
        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('locationiq', function ($job) {
            $maxAttempts = max(
                1,
                (int) config('locationiq.rate_limit_max_attempts', 2)
            );

            $decaySeconds = max(
                1,
                (int) config('locationiq.rate_limit_decay_seconds', 1)
            );

            return Limit::perSecond(
                $maxAttempts,
                $decaySeconds
            )->by('global');
        });
    }
}
