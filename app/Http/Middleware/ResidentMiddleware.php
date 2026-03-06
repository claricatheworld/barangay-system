<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResidentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role !== 'resident') {
            return redirect('/unauthorized');
        }

        $user = auth()->user();

        if ($user->status === 'pending') {
            return redirect('/pending');
        }

        if ($user->status === 'rejected') {
            auth()->logout();
            return redirect('/login')->with('error', 'Your account has been rejected. Please contact the barangay office.');
        }

        return $next($request);
    }
}
