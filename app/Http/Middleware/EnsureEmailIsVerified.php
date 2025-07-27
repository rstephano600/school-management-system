<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $redirectToRoute = null): Response
    {
        // Check if user is authenticated
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Check if user has an email address
        if (! $request->user()->email) {
            // For API requests, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Email address is required to access this resource.',
                ], 422);
            }

            // For web requests, redirect to profile or specified route
            return $redirectToRoute 
                ? Redirect::route($redirectToRoute)
                : Redirect::route('profile.edit')->with('error', 'Please add an email address to your profile.');
        }

        return $next($request);
    }
}