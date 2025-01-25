<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStudentRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'student') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'This account does not have student access.',
            ]);
        }

        return $next($request);
    }
}
