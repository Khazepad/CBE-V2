<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureStudent
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            return $next($request);
        }

        return redirect('/'); // Redirect to home or any other page if not a student
    }
}
