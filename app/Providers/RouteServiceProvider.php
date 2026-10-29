<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            $user = $request->user();
            $identifier = $user ? $user->id : $request->ip();
            return Limit::perMinute(60)->by($identifier);
        });

        // OTP Email Rate Limiter (Max 3 per minute by IP, max 2 per minute by email)
        RateLimiter::for('otp', function (Request $request) {
            $email = (string) $request->input('email', session('otp_email', ''));
            return [
                Limit::perMinute(3)->by($request->ip())->response(function () {
                    return back()->withErrors(['email' => 'Terlalu banyak permintaan OTP dari perangkat Anda. Silakan tunggu 1 menit sebelum mencoba kembali.'])->withInput();
                }),
                Limit::perMinute(2)->by(strtolower(trim($email)))->response(function () {
                    return back()->withErrors(['email' => 'Permintaan OTP untuk email ini terlalu sering. Silakan tunggu 1 menit sebelum mencoba kembali.'])->withInput();
                }),
            ];
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('checkout', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        RateLimiter::for('upload', function (Request $request) {
            return Limit::perMinute(15)->by($request->ip());
        });
    }
}
