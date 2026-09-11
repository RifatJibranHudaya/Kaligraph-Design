<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on guard type
                if ($guard === 'customer') {
                    return redirect()->route('customer.dashboard');
                }
                
                // For web guard (admin/staff), redirect based on user type
                if ($guard === null || $guard === 'web') {
                    $user = Auth::guard($guard)->user();
                    if ($user && $user->isCustomer()) {
                        return redirect()->route('customer.dashboard');
                    }
                    return redirect()->route('dashboard');
                }
                
                // Default fallback
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
