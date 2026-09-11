<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the request is for customer routes
        if ($this->isCustomerRoute($request)) {
            // If customer guard is authenticated, allow access
            if (Auth::guard('customer')->check()) {
                return null;
            }
            return route('login.customer');
        }

        // For admin/staff routes, check web guard
        if (Auth::guard('web')->check()) {
            return null;
        }

        // Default to admin login
        return route('login.admin');
    }

    /**
     * Determine if the request is for a customer route.
     */
    private function isCustomerRoute(Request $request): bool
    {
        $path = $request->path();
        
        // Check if path starts with 'customer' or matches customer routes
        if (str_starts_with($path, 'customer')) {
            return true;
        }

        // Check route name if available
        $route = $request->route();
        if ($route) {
            $routeName = $route->getName();
            if ($routeName && str_starts_with($routeName, 'customer.')) {
                return true;
            }
        }

        return false;
    }
}
