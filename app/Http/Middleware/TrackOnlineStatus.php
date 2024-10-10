<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TrackOnlineStatus
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */

    public function handle($request, Closure $next)
    {
        Log::info('Middleware invoked');
        Log::info('Auth check result: ' . (Auth::check() ? 'Authenticated' : 'Not authenticated'));

        if (Auth::check()) {
            Log::info('checked');
            $user = Auth::user();
            Log::info($user);
            $user->update(['online' => true]);

            $user->update(['ip_address' => $request->ip()]);
        }

        return $next($request);
    }
}
