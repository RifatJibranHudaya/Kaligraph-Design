<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $feature
     * @param  string  $action
     */
    public function handle(Request $request, Closure $next, string $feature, string $action = 'read'): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->hasPermission($feature, $action)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Anda tidak memiliki hak akses untuk tindakan ini.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses untuk fitur ini (' . $feature . ').');
        }

        return $next($request);
    }
}
