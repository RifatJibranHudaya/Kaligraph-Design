<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user('web') ?? $request->user();

        if (!$user) {
            return redirect()->route('login.admin');
        }

        if (!$user->hasRole($roles)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized access.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
