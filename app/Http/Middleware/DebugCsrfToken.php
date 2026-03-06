<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class DebugCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check POST, PUT, DELETE, PATCH requests
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete') || $request->isMethod('patch')) {
            // Get token from request
            $requestToken = $request->input('_token') ?? $request->header('X-CSRF-TOKEN');
            $sessionToken = $request->session()->token();
            
            // Log the tokens for debugging (remove in production)
            if (config('app.debug')) {
                \Log::debug('CSRF Token Debug', [
                    'path' => $request->path(),
                    'method' => $request->method(),
                    'request_token' => $requestToken ? substr($requestToken, 0, 10) . '...' : 'MISSING',
                    'session_token' => $sessionToken ? substr($sessionToken, 0, 10) . '...' : 'MISSING',
                    'tokens_match' => $requestToken === $sessionToken,
                    'session_id' => $request->session()->getId(),
                    'user_agent' => substr($request->header('User-Agent', ''), 0, 60),
                ]);
            }
        }

        return $next($request);
    }
}
