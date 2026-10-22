<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        $this->configureRateLimiting();
    }

    /**
     * Configure custom rate limiters for sensitive endpoints.
     */
    protected function configureRateLimiting(): void
    {
        // Login endpoints: 5 attempts per minute per IP
        RateLimiter::for('login', function (Request $request) {
            $key = $request->input('username', $request->input('email', ''));
            return Limit::perMinute(5)
                ->by($key . '|' . $request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'username' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam 1 menit.',
                    ]);
                });
        });

        // OTP endpoints: 3 attempts per minute per IP
        RateLimiter::for('otp', function (Request $request) {
            return Limit::perMinute(3)
                ->by($request->input('email', '') . '|' . $request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Terlalu banyak permintaan OTP. Silakan tunggu 1 menit.',
                    ]);
                });
        });

        // Registration: 3 per 10 minutes per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinutes(10, 3)
                ->by($request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Terlalu banyak percobaan registrasi. Silakan coba lagi nanti.',
                    ]);
                });
        });

        // Checkout/Payment: 10 attempts per minute per user
        RateLimiter::for('checkout', function (Request $request) {
            $userId = $request->user()?->id ?? $request->ip();
            return Limit::perMinute(10)->by('checkout|' . $userId);
        });

        // File upload: 10 per minute per user
        RateLimiter::for('upload', function (Request $request) {
            $userId = $request->user()?->id ?? $request->ip();
            return Limit::perMinute(10)->by('upload|' . $userId);
        });
    }
}
