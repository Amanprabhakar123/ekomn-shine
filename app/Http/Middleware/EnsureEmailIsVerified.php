<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and their email is not verified
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            // Redirect the user to the email verification page
            return redirect()->route('verification.email.verify');
        }
        return $next($request);
    }
}
